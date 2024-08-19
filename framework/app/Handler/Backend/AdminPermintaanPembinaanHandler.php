<?php

declare(strict_types=1);

namespace App\Handler\Backend;

use App\Enums\PathEnum;
use App\Enums\ResourceEnum;
use App\Handler\ActionHandler;
use App\Helper\Service;
use App\Model\Db\DokumentasiPembinaanModel;
use App\Model\Db\PermintaanPembinaanJoinModel;
use App\Model\Db\PermintaanPembinaanModel;
use App\Model\Db\PesanPermintaanJoinUserModel;
use App\Model\Db\PesanPermintaanModel;
use App\Model\Db\StatusPermintaanModel;
use App\Model\Forms\PesanPermintaanForm;
use Faster\Component\Enums\HttpMethodEnum;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminPermintaanPembinaanHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_LIST or path '/internal/permintaan-pembinaan'
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
            $where = "a.deskripsi LIKE '%{$q}%'";
        } else {
            $q = null;
            $where = null;
        }
        $params['page'] = 'DAFTAR PERMINTAAN PEMBINAAN';
        $params['breadcrumbs'] = [];
        $params['q'] = $q;
        $params['data'] = PermintaanPembinaanJoinModel::paginate($where, '*', null, 'a.create_at DESC');

        return view('permintaan_pembinaan_list', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_VIEW or path '/internal/pembinaan-pembinaan/view/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function viewPermintaanPembinaan(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $row = PermintaanPembinaanJoinModel::row('*', ['a.id=' => $id]);
        if (!$row) {
            session()->addFlashWarning('Data tidak ditemukan.');
            return redirect_to(ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_LIST);
        }

        $model = new PesanPermintaanForm();
        if ($request->getMethod() === HttpMethodEnum::POST) {
            $post = Service::sanitize($request);
            if (isset($post['simpan'])) {
                if (auth()->hasPermission(ResourceEnum::ADMIN_STATUS_PERMINTAAN_PEMBINAAN_EDIT)) {
                    try {
                        if (StatusPermintaanModel::exists(['id=' => $post['status']])) {
                            PermintaanPembinaanModel::update(
                                ['status' => $post['status']],
                                ['id=' => $id]
                            );
                            session()->addFlashSuccess('Ubah status permintaan berhasil');
                        }
                    } catch (Exception $e) {
                        session()->addFlashError('Ubah status permintaan gagal. Error:' . $e->getMessage());
                    }
                } else {
                    session()->addFlashWarning('Anda tidak berhak untuk mengubah status permintaan pembinaan.');
                }
                return redirect_to(ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_VIEW, strval($id));
            } elseif (isset($post['kirim'])) {
                if (auth()->hasPermission(ResourceEnum::ADMIN_PESAN_PERMINTAAN_PEMBINAAN_POST)) {
                    if ($model->fillAndValidate($post)) {
                        try {
                            PesanPermintaanModel::create(
                                [
                                    'permintaan_id' => $id,
                                    'waktu' => local_time(),
                                    'user_id' => auth()->getIdentity()->getId(),
                                    'pesan' => $model->pesan
                                ]
                            );
                            session()->addFlashSuccess('Kirim pesan berhasil');
                        } catch (Exception $e) {
                            session()->addFlashError('Kirim pesan gagal. Error:' . $e->getMessage());
                        }
                        return redirect_to(ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_VIEW, strval($id));
                    }
                } else {
                    session()->addFlashWarning('Anda tidak berhak untuk mengisi percakapan.');
                    return redirect_to(ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_VIEW, strval($id));
                }
            }
        }
        $params['page'] = 'DETAIL PERMINTAAN PEMBINAAN';
        $params['breadcrumbs'] = [
            'PERMINTAAN PEMBINAAN STATISTIK' => route(ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_LIST)
        ];
        $params['id'] = $id;
        $params['row'] = $row;
        $params['model'] = $model;
        $params['petugas'] = auth()->getIdentity()->getData();
        $params['messages'] = PesanPermintaanJoinUserModel::find(['permintaan_id=' => $id], '*', 0, -1, 'a.id ASC');
        $params['listStatus'] = StatusPermintaanModel::all();
        $params['dokumentasi'] = DokumentasiPembinaanModel::row('*', ['permintaan_id=' => $id]);

        return view('permintaan_pembinaan_view', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_DELETE or path '/internal/permintaan-pembinaan/delete/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function deletePermintaanPembinaan(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $row = PermintaanPembinaanModel::row('*', ['id=' => $id]);
        if ($row) {
            try {
                $filename = $row['surat'] ?? null;
                $path = ROOT . app_config(PathEnum::PERMINTAAN_PEMBINAAN);
                if ($filename && is_file($path . '/' . $filename)) {
                    unlink($path . '/' . $filename);
                }
                PesanPermintaanModel::delete(['permintaan_id=' => $id]);
                DokumentasiPembinaanModel::update(['permintaan_id' => NULL], ['permintaan_id=' => $id]);
                PermintaanPembinaanModel::delete(['id=' => $id]);
                session()->addFlashSuccess('Hapus permintaan pembinaan berhasil.');
            } catch (Exception $e) {
                session()->addFlashError('Hapus permintaan pembinaan gagal. Error:' . $e->getMessage());
            }
        } else {
            session()->addFlashWarning('Data permintaan pembinaan tidak ditemukan');
        }

        return redirect_to(ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_LIST);
    }
}
