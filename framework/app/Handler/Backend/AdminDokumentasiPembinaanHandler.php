<?php

declare(strict_types=1);

namespace App\Handler\Backend;

use App\Enums\PathEnum;
use App\Handler\ActionHandler;
use App\Model\Db\DokumentasiPembinaanModel;
use App\Model\Db\DokumentasiPembinaanJoinUserModel;
use App\Model\Forms\DokumentasiPembinaanForm;
use Faster\Component\Enums\HttpMethodEnum;
use App\Enums\ResourceEnum;
use App\Enums\StatusPermintaanEnum;
use App\Model\Db\PermintaanPembinaanModel;
use Exception;
use Faster\Helper\Service;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

class AdminDokumentasiPembinaanHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::ADMIN_DOKUMENTASI_LIST or path '/internal/dokumentasi-pembinaan'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $query = $request->getQueryParams();
        if (isset($query['q']) && $query['q']) {
            $q = esc($query['q']);
            $where = "`judul` LIKE '%{$q}%' or `berita` LIKE '%{$q}%'";
        } else {
            $q = null;
            $where = null;
        }
        $params['page'] = 'DAFTAR DOKUMENTASI PEMBINAAN';
        $params['breadcrumbs'] = [];
        $params['q'] = $q;
        $params['data'] = DokumentasiPembinaanModel::paginate($where, '*', 9, 'tanggal DESC');

        return view('dokumentasi_pembinaan_list', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum::ADMIN_DOKUMENTASI_VIEW or path '/internal/dokumentasi-pembinaan/view/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function view(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params['page'] = 'DETAIL DOKUMENTASI PEMBINAAN';
        $params['breadcrumbs'] = [
            'DAFTAR DOKUMENTASI PEMBINAAN' => route(ResourceEnum::ADMIN_DOKUMENTASI_LIST)
        ];
        $id = $request->getAttribute('id');
        $params['id'] = $id;
        $params['row'] = DokumentasiPembinaanJoinUserModel::row('*', ['a.id=' => $id]);

        return view('dokumentasi_pembinaan_view', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum::ADMIN_DOKUMENTASI_EDIT or path '/internal/dokumentasi-pembinaan/edit/{id:\id+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function edit(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params['page'] = 'UBAH DOKUMENTASI PEMBINAAN';
        $params['breadcrumbs'] = [
            'DAFTAR DOKUMENTASI PEMBINAAN' => route(ResourceEnum::ADMIN_DOKUMENTASI_LIST)
        ];

        $id = $request->getAttribute('id');
        $row = DokumentasiPembinaanModel::row('*', ['id=' => $id]);
        $model = new DokumentasiPembinaanForm(true);
        if ($row) {
            $model->fill($row);
            if ($request->getMethod() === HttpMethodEnum::POST) {
                $post = Service::sanitize($request, 'berita');
                $post['is_active'] = isset($post['is_active']) ? 1 : 0;
                if ($model->fillAndValidate($post)) {
                    foreach ($request->getUploadedFiles() as $file) {
                        if ($file instanceof UploadedFileInterface) {
                            if ($file->getError() === UPLOAD_ERR_OK && $file->getSize() > 0) {
                                $fileExt = strtolower(pathinfo($file->getClientFileName(), PATHINFO_EXTENSION));
                                $allowed_file_ext = ['png', 'jpg', 'jpeg', 'gif'];
                                $max_size = app_config('max_image_size');
                                if ($file->getSize() > $max_size) { 
                                    $mb_size = $max_size / 1000000;
                                    $model->addError("Ukuran file lebih dari {$mb_size}MB.", 'gambar');
                                } elseif (!in_array($fileExt, $allowed_file_ext)) {
                                    $allowed_file_ext_string = implode(', ', $allowed_file_ext);
                                    $model->addError("Tipe file harus {$allowed_file_ext_string}.", 'gambar');
                                } else {
                                    try {
                                        $path = ROOT . app_config(PathEnum::IMAGE_DOKUMENTASI_PEMBINAAN);
                                        if ($model->gambar && is_file($path . '/' . $model->gambar)) {
                                            unlink($path . '/' . $model->gambar);
                                        }
                                        $model->gambar = sprintf("%d.{$fileExt}", local_time());
                                        $file->moveTo($path . $model->gambar);
                                    } catch (Exception $e) {
                                        $model->addError('Upload file gambar gagal. Error:' . $e->getMessage(),  'gambar');
                                    }
                                }
                            }
                        }
                    }
                    if (!$model->hasError()) {
                        if(!auth()->hasPermission(ResourceEnum::ADMIN_DOKUMENTASI_APPROVE)){
                            $model->is_active = $row['is_active'];
                        }
                        try {
                            DokumentasiPembinaanModel::update(
                                [
                                    'judul' => $model->judul,
                                    'berita' => $model->berita,
                                    'is_active' => $model->is_active,
                                    'gambar' => $model->gambar,
                                    'tanggal' => $model->tanggal,
                                    'update_by' => auth()->getIdentity()->getId(),
                                    'update_at' => local_time()
                                ],
                                ['id=' => $id]
                            );
                            session()->addFlashSuccess('Simpan dokumentasi pembinaan berhasil');
                        } catch (Exception $e) {
                            session()->addFlashError('Simpan dokumentasi pembinaan gagal. Error:' . $e->getMessage());
                        }
                        return redirect_to(ResourceEnum::ADMIN_DOKUMENTASI_LIST);
                    }
                }
            }
        } else {
            session()->addFlashWarning('Data dokumentasi pembinaan tidak ditemukan');
            return redirect_to(ResourceEnum::ADMIN_DOKUMENTASI_LIST);
        }
        $params['id'] = $id;
        $params['model'] = $model;

        return view('dokumentasi_pembinaan_form', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum::ADMIN_DOKUMENTASI_ENTRY or path '/internal/dokumentasi-pembinaan/entri'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function entry(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params['page'] = 'TAMBAH DOKUMENTASI PEMBINAAN BARU';
        $params['breadcrumbs'] = [
            'DAFTAR DOKUMENTASI PEMBINAAN' => route(ResourceEnum::ADMIN_DOKUMENTASI_LIST)
        ];

        $model = new DokumentasiPembinaanForm();
        $permintaan_id = $request->getAttribute('id');
        if ($permintaan_id) {
            $approved = StatusPermintaanEnum::APPROVED;
            $closed = StatusPermintaanEnum::CLOSED;
            $row = PermintaanPembinaanModel::row('*', "id=$permintaan_id AND status IN ($approved,$closed)");
            if (!$row) {
                session()->addFlashWarning('Data permintaan pembinaan tidak ditemukan');
                return redirect_to(ResourceEnum::ADMIN_DOKUMENTASI_LIST);
            }
            $model->permintaan_id = $permintaan_id;
            $model->tanggal = $row['tanggal'];
        }

        if ($request->getMethod() === HttpMethodEnum::POST) {
            $post = Service::sanitize($request, 'berita');
            if ($model->fillAndValidate($post)) {
                foreach ($request->getUploadedFiles() as $file) {
                    if ($file instanceof UploadedFileInterface) {
                        if ($file->getError() === UPLOAD_ERR_OK && $file->getSize() > 0) {
                            $fileExt = strtolower(pathinfo($file->getClientFileName(), PATHINFO_EXTENSION));
                            $allowed_file_ext = ['png', 'jpg', 'jpeg', 'gif'];
                            $max_size = app_config('max_image_size');
                            if ($file->getSize() > $max_size) { 
                                $mb_size = $max_size / 1000000;
                                $model->addError("Ukuran file lebih dari {$mb_size}MB.", 'gambar');
                            } elseif (!in_array($fileExt, $allowed_file_ext)) {
                                $allowed_file_ext_string = implode(', ', $allowed_file_ext);
                                $model->addError("Tipe file harus {$allowed_file_ext_string}.", 'gambar');
                            } else {
                                try {
                                    $model->gambar = sprintf("%d.{$fileExt}", local_time());
                                    $path = ROOT . app_config(PathEnum::IMAGE_DOKUMENTASI_PEMBINAAN);
                                    $file->moveTo($path . '/' . $model->gambar);
                                } catch (Exception $e) {
                                    $model->addError('Upload file gambar gagal. Error:' . $e->getMessage(),  'gambar');
                                }
                            }
                        }
                    }
                }
                if (!$model->hasError()) {
                    try {
                        DokumentasiPembinaanModel::create(
                            [
                                'judul' => $model->judul,
                                'berita' => $model->berita,
                                'is_active' => 0,
                                'permintaan_id' => $model->permintaan_id,
                                'gambar' => $model->gambar,
                                'tanggal' => $model->tanggal,
                                'create_by' => auth()->getIdentity()->getId(),
                                'create_at' => local_time()
                            ]
                        );
                        session()->addFlashSuccess('Simpan dokumentasi berhasil');
                    } catch (Exception $e) {
                        session()->addFlashError('Simpan dokumentasi gagal. Error:' . $e->getMessage());
                    }
                    return redirect_to(ResourceEnum::ADMIN_DOKUMENTASI_LIST);
                }
            }
        }
        $params['model'] = $model;

        return view('dokumentasi_pembinaan_form', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum::ADMIN_DOKUMENTASI_DELETE or path '/internal/dokumentasi-pembinaan/delete/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {       
        $id = $request->getAttribute('id');
        $row = DokumentasiPembinaanModel::row('*', ['id=' => $id]);
        if ($row) {
            try {
                $filename = $row['gambar'] ?? null;
                $path = ROOT . app_config(PathEnum::IMAGE_DOKUMENTASI_PEMBINAAN);
                if ($filename && is_file($path . '/' . $filename)) {
                    unlink($path . '/' . $filename);
                }
                DokumentasiPembinaanModel::delete(['id=' => $id]);
                session()->addFlashSuccess('Hapus dokumentasi pembinaan berhasil.');
            } catch (Exception $e) {
                session()->addFlashError('Hapus dokumentasi pembinaan gagal. Error:' . $e->getMessage());
            }
        } else {
            session()->addFlashWarning('Data dokumentasi tidak ditemukan');
        }

        return redirect_to(ResourceEnum::ADMIN_DOKUMENTASI_LIST);
    }
}
