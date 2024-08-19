<?php

declare(strict_types=1);

namespace App\Handler\Backend;

use App\Enums\ResourceEnum;
use App\Enums\PathEnum;
use App\Handler\ActionHandler;
use App\Model\Db\ModulLiterasiModel;
use App\Model\Db\KategoriModulLiterasiModel;
use App\Model\Forms\ModulLiterasiForm;
use Faster\Component\Enums\HttpMethodEnum;
use Faster\Helper\Service;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

class AdminModulLiterasiHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::ADMIN_MODUL_LITERASI_LIST or path '/internal/modul-literasi[/{cat:\d+}]'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $k = $request->getAttribute('cat') ?? 1;
        if (!KategoriModulLiterasiModel::exists(['id=' => $k])) {
            return redirect_to(ResourceEnum::ADMIN_MODUL_LITERASI_LIST);
        }
        $query = $request->getQueryParams();
        if (isset($query['q']) && $query['q']) {
            $q = esc($query['q']);
            $where = "(`nama` LIKE '%{$q}%' OR `deskripsi` LIKE '%{$q}%') and `kategori`='{$k}'";
        } else {
            $q = null;
            $where = ['kategori=' => $k];
        }
        $params['page'] = 'DAFTAR MODUL LITERASI';
        $params['breadcrumbs'] = [];
        $params['kategori'] = $k;
        $params['q'] = $q;
        $params['data'] = ModulLiterasiModel::paginate($where, '*');
        $params['categories'] = KategoriModulLiterasiModel::all();

        return view('modul_literasi_list', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum::ADMIN_MODUL_LITERASI_EDIT or path '/internal/modul-literasi/edit/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function edit(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params['page'] = 'UBAH DATA MODUL';
        $params['breadcrumbs'] = [
            'DAFTAR MODUL' => route(ResourceEnum::ADMIN_MODUL_LITERASI_LIST)
        ];
        $id = $request->getAttribute('id');
        $row = ModulLiterasiModel::row('*', ['id=' => $id]);
        if (!$row) {
            session()->addFlashWarning('Data modul tidak ditemukan');
            return redirect_to(ResourceEnum::ADMIN_MODUL_LITERASI_LIST);
        }
        $model = new ModulLiterasiForm(true);
        $model->fill($row);
        if ($request->getMethod() === HttpMethodEnum::POST) {
            $post = Service::sanitize($request);
            $post['is_active'] = isset($post['is_active']) ? 1 : 0;
            if ($model->fillAndValidate($post)) {
                foreach ($request->getUploadedFiles() as $file) {
                    if ($file instanceof UploadedFileInterface) {
                        if ($file->getError() === UPLOAD_ERR_OK && $file->getSize() > 0) {
                            $fileExt = strtolower(pathinfo($file->getClientFileName(), PATHINFO_EXTENSION));
                            $allowed_file_ext = ['pdf'];
                            $max_size = app_config('max_upload_size');
                            if ($file->getSize() > $max_size) { 
                                $mb_size = $max_size / 1000000;
                                $model->addError("Ukuran file lebih dari {$mb_size}MB.", 'link');
                            } elseif (!in_array($fileExt, $allowed_file_ext)) {
                                $allowed_file_ext_string = implode(', ', $allowed_file_ext);
                                $model->addError("Tipe file harus {$allowed_file_ext_string}.", 'link');
                            } else {
                                try {
                                    $path = ROOT . app_config(PathEnum::MODUL_LITERASI);
                                    if ($row['link'] && is_file($path . '/' . $row['link'])) {
                                        unlink($path . '/' . $row['link']);
                                    }
                                    $filename = sprintf('%d.pdf', local_time());
                                    $file->moveTo($path . '/' . $filename);
                                    $model->link = $filename;
                                } catch (Exception $e) {
                                    $model->addError('Upload file modul gagal. Error:' . $e->getMessage(), 'link');
                                }
                            }
                        }
                    }
                }
            }
            if (!$model->hasError()) {
                try {
                    ModulLiterasiModel::update(
                        [
                            'nama' => $model->nama,
                            'deskripsi' => $model->deskripsi,
                            'kategori' => $model->kategori,
                            'link' => $model->link,
                            'is_active' => $model->is_active,
                            'update_by' => auth()->getIdentity()->getId(),
                            'update_at' => local_time()
                        ],
                        ['id=' => $id]
                    );
                    session()->addFlashSuccess('Simpan modul berhasil');
                } catch (Exception $e) {
                    session()->addFlashError('Simpan modul gagal. Error:' . $e->getMessage());
                }
                return redirect_to(ResourceEnum::ADMIN_MODUL_LITERASI_LIST, $model->kategori ? "/{$model->kategori}" : "/{$row['kategori']}");
            }
        }
        $params['row'] = $row;
        $params['model'] = $model;
        $values = [];
        $labels = [];
        foreach (KategoriModulLiterasiModel::all('id,nama', 'id ASC') as $cat) {
            array_push($values, $cat['id']);
            array_push($labels, $cat['nama']);
        }
        $params['values'] = $values;
        $params['labels'] = $labels;

        return view('modul_literasi_form', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum::ADMIN_MODUL_LITERASI_ENTRY or path '/internal/modul-literasi/entri[/{cat:\d+}]'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function entry(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $k = $request->getAttribute('cat') ?? 1;
        if (!KategoriModulLiterasiModel::exists(['id=' => $k])) {
            return redirect_to(ResourceEnum::ADMIN_MODUL_LITERASI_ENTRY);
        }

        $model = new ModulLiterasiForm();
        $model->kategori = $k;
        if ($request->getMethod() === HttpMethodEnum::POST) {
            $post = Service::sanitize($request);
            $post['is_active'] = isset($post['is_active']) ? 1 : 0;
            if ($model->fillAndValidate($post)) {    
                foreach ($request->getUploadedFiles() as $file) {
                    if ($file instanceof UploadedFileInterface) {
                        if ($file->getError() === UPLOAD_ERR_OK && $file->getSize() > 0) {
                            $fileExt = strtolower(pathinfo($file->getClientFileName(), PATHINFO_EXTENSION));
                            $allowed_file_ext = ['pdf'];
                            $max_size = app_config('max_upload_size');
                            if ($file->getSize() > $max_size) { 
                                $mb_size = $max_size / 1000000;
                                $model->addError("Ukuran file lebih dari {$mb_size}MB.", 'link');
                            } elseif (!in_array($fileExt, $allowed_file_ext)) {
                                $allowed_file_ext_string = implode(', ', $allowed_file_ext);
                                $model->addError("Tipe file harus {$allowed_file_ext_string}.", 'link');
                            } else {
                                try {
                                    $model->link = sprintf('%d.pdf', local_time());
                                    $path = ROOT . app_config(PathEnum::MODUL_LITERASI);
                                    $file->moveTo($path . '/' . $model->link);
                                } catch (Exception $e) {
                                    $model->addError('Upload file modul gagal. Error:' . $e->getMessage(),  'link');
                                }
                            }
                        }
                    }
                }                
                if (!$model->hasError() && $model->link) {
                    try {
                        ModulLiterasiModel::create(
                            [
                                'nama' => $model->nama,
                                'deskripsi' => $model->deskripsi,
                                'kategori' => $model->kategori,
                                'is_active' => $model->is_active,
                                'link' => $model->link,
                                'create_by' => auth()->getIdentity()->getId(),
                                'create_at' => local_time()
                            ]
                        );
                        session()->addFlashSuccess('Simpan modul berhasil');
                    } catch (Exception $e) {
                        session()->addFlashError('Simpan modul gagal. Error:' . $e->getMessage());
                    }
                    return redirect_to(ResourceEnum::ADMIN_MODUL_LITERASI_LIST, $model->kategori ? "/{$model->kategori}" : "/{$k}");
                }
            }
        }
        $params['page'] = 'TAMBAH MODUL LITERASI BARU';
        $params['breadcrumbs'] = [
            'DAFTAR MODUL LITERASI' => route(ResourceEnum::ADMIN_MODUL_LITERASI_LIST)
        ];
        $params['kategori'] = $k;
        $params['model'] = $model;
        $values = [];
        $labels = [];
        foreach (KategoriModulLiterasiModel::all('id,nama', 'id ASC') as $cat) {
            array_push($values, $cat['id']);
            array_push($labels, $cat['nama']);
        }
        $params['values'] = $values;
        $params['labels'] = $labels;

        return view('modul_literasi_form', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum::ADMIN_MODUL_LITERASI_DELETE or path '/internal/modul-literasi/delete/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $row = ModulLiterasiModel::row('*', ['id=' => $id]);
        if ($row) {
            try {
                $path = ROOT . app_config(PathEnum::MODUL_LITERASI);
                $filename = $row['link'] ?? null;
                if ($filename && is_file($path .  '/' . $filename)) {
                    unlink($path . '/' . $filename);
                }
                ModulLiterasiModel::delete(['id=' => $id]);
                session()->addFlashSuccess('Hapus modul berhasil.');
            } catch (Exception $e) {
                session()->addFlashError('Hapus modul gagal. Error:' . $e->getMessage());
            }
        } else {
            session()->addFlashWarning('Data modul tidak ditemukan');
        }

        return redirect_to(ResourceEnum::ADMIN_MODUL_LITERASI_LIST, empty($row) ? '' : "/{$row['kategori']}");
    }
}
