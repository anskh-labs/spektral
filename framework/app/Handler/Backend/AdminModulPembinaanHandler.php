<?php

declare(strict_types=1);

namespace App\Handler\Backend;

use App\Enums\ResourceEnum;
use App\Enums\PathEnum;
use App\Handler\ActionHandler;
use App\Model\Db\ModulPembinaanModel;
use App\Model\Db\KategoriModulPembinaanModel;
use App\Model\Forms\ModulPembinaanForm;
use Faster\Component\Enums\HttpMethodEnum;
use Faster\Helper\Service;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

class AdminModulPembinaanHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::ADMIN_MODUL_PEMBINAAN_LIST or path '/internal/modul-pembinaan[/{cat:\d+}]'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $k = $request->getAttribute('cat') ?? 1;
        if (!KategoriModulPembinaanModel::exists(['id=' => $k])) {
            return redirect_to(ResourceEnum::ADMIN_MODUL_PEMBINAAN_LIST);
        }
        $query = $request->getQueryParams();
        if (isset($query['q']) && $query['q']) {
            $q = esc($query['q']);
            $where = "(`nama` LIKE '%{$q}%' OR `deskripsi` LIKE '%{$q}%') and `kategori`='{$k}'";
        } else {
            $q = null;
            $where = ['kategori=' => $k];
        }
        $params['page'] = 'DAFTAR MODUL PEMBINAAN';
        $params['breadcrumbs'] = [];
        $params['kategori'] = $k;
        $params['q'] = $q;
        $params['data'] = ModulPembinaanModel::paginate($where, '*');
        $params['categories'] = KategoriModulPembinaanModel::all();

        return view('modul_pembinaan_list', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum::ADMIN_MODUL_PEMBINAAN_EDIT or path '/internal/modul-pembinaan/edit/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function edit(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params['page'] = 'UBAH DATA MODUL';
        $params['breadcrumbs'] = [
            'DAFTAR MODUL' => route(ResourceEnum::ADMIN_MODUL_PEMBINAAN_LIST)
        ];
        $id = $request->getAttribute('id');
        $row = ModulPembinaanModel::row('*', ['id=' => $id]);
        if (!$row) {
            session()->addFlashWarning('Data modul tidak ditemukan');
            return redirect_to(ResourceEnum::ADMIN_MODUL_PEMBINAAN_LIST);
        }
        $model = new ModulPembinaanForm(true);
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
                                    $path = ROOT . app_config(PathEnum::MODUL_PEMBINAAN);
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
                    ModulPembinaanModel::update(
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
                return redirect_to(ResourceEnum::ADMIN_MODUL_PEMBINAAN_LIST, $model->kategori ? "/{$model->kategori}" : "/{$row['kategori']}");
            }
        }
        $params['row'] = $row;
        $params['model'] = $model;
        $values = [];
        $labels = [];
        foreach (KategoriModulPembinaanModel::all('id,nama', 'id ASC') as $cat) {
            array_push($values, $cat['id']);
            array_push($labels, $cat['nama']);
        }
        $params['values'] = $values;
        $params['labels'] = $labels;

        return view('modul_pembinaan_form', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum::ADMIN_MODUL_PEMBINAAN_ENTRY or path '/internal/modul-pembinaan/entri[/{cat:\d+}]'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function entry(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $k = $request->getAttribute('cat') ?? 1;
        if (!KategoriModulPembinaanModel::exists(['id=' => $k])) {
            return redirect_to(ResourceEnum::ADMIN_MODUL_PEMBINAAN_ENTRY);
        }

        $model = new ModulPembinaanForm();
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
                                    $path = ROOT . app_config(PathEnum::MODUL_PEMBINAAN);
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
                        ModulPembinaanModel::create(
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
                    return redirect_to(ResourceEnum::ADMIN_MODUL_PEMBINAAN_LIST, $model->kategori ? "/{$model->kategori}" : "/{$k}");
                }
            }
        }
        $params['page'] = 'TAMBAH MODUL PEMBINAAN BARU';
        $params['breadcrumbs'] = [
            'DAFTAR MODUL PEMBINAAN' => route(ResourceEnum::ADMIN_MODUL_PEMBINAAN_LIST)
        ];
        $params['kategori'] = $k;
        $params['model'] = $model;
        $values = [];
        $labels = [];
        foreach (KategoriModulPembinaanModel::all('id,nama', 'id ASC') as $cat) {
            array_push($values, $cat['id']);
            array_push($labels, $cat['nama']);
        }
        $params['values'] = $values;
        $params['labels'] = $labels;

        return view('modul_pembinaan_form', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum::ADMIN_MODUL_PEMBINAAN_DELETE or path '/internal/modul-pembinaan/delete/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $row = ModulPembinaanModel::row('*', ['id=' => $id]);
        if ($row) {
            try {
                $path = ROOT . app_config(PathEnum::MODUL_PEMBINAAN);
                $filename = $row['link'] ?? null;
                if ($filename && is_file($path .  '/' . $filename)) {
                    unlink($path . '/' . $filename);
                }
                ModulPembinaanModel::delete(['id=' => $id]);
                session()->addFlashSuccess('Hapus modul berhasil.');
            } catch (Exception $e) {
                session()->addFlashError('Hapus modul gagal. Error:' . $e->getMessage());
            }
        } else {
            session()->addFlashWarning('Data modul tidak ditemukan');
        }

        return redirect_to(ResourceEnum::ADMIN_MODUL_PEMBINAAN_LIST, empty($row) ? '' : "/{$row['kategori']}");
    }
}
