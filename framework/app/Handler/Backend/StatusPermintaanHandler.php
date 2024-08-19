<?php

declare(strict_types=1);

namespace App\Handler\Backend;

use App\Enums\ResourceEnum;
use App\Handler\ActionHandler;
use App\Model\Db\StatusPermintaanModel;
use App\Model\Db\PermintaanPembinaanModel;
use App\Model\Forms\StatusPermintaanForm;
use Exception;
use Faster\Component\Enums\HttpMethodEnum;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class StatusPermintaanHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::ADMIN_MODEL_PEMBINAAN_LIST or path '/internal/status-permintaan'
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
            $where = "`nama` LIKE '%{$q}%'";
        } else {
            $q = null;
            $where = null;
        }
        $params['page'] = 'DAFTAR STATUS PERMINTAAN';
        $params['breadcrumbs'] = [];
        $params['q'] = $q;
        $params['data'] = StatusPermintaanModel::paginate($where, '*');

        return view('status_permintaan_list', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum:ADMIN_STATUS_PERMINTAAN_DELETE or path '/internal/status-permintaan/delete/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $id = $request->getAttribute('id');
            if(PermintaanPembinaanModel::exists(['status=' => $id])){
                session()->addFlashWarning('Status permintaan sedang digunakan sehingga tidak dapat dihapus.');
                return redirect_to(ResourceEnum::ADMIN_STATUS_PERMINTAAN_LIST);
            }
            StatusPermintaanModel::delete(['id='=>$id]);
            session()->addFlashSuccess('Hapus status permintaan berhasil.');
        } catch (Exception $e) {
            session()->addFlashError('Gagal hapus status permintaan. Error:' . $e->getMessage());
        }

        return redirect_to(ResourceEnum::ADMIN_STATUS_PERMINTAAN_LIST);
    }
    /**
     * Handle route ResourceEnum:ADMIN_STATUS_PERMINTAAN_EDIT or path '/internal/status-permintaan/edit/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function edit(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $row = StatusPermintaanModel::row('*', ['id=' => $id]);
        $model = new StatusPermintaanForm(true);
        $model->fill($row);
        if ($request->getMethod() === HttpMethodEnum::POST) {
            if ($model->fillAndValidateWith($request)) {
                try {
                    StatusPermintaanModel::update([
                        'nama' => $model->nama,
                        'update_at' => local_time(),
                        'update_by' => auth()->getIdentity()->getId()
                    ], ['id=' => $id]);
                    session()->addFlashSuccess('Data berhasil disimpan');
                } catch (Exception $e) {
                    session()->addFlashError('Data gagal disimpan. Error:' . $e->getMessage());
                }
                return redirect_to(ResourceEnum::ADMIN_STATUS_PERMINTAAN_LIST);
            }
        }
        $params['page'] = 'UBAH STATUS PERMINTAAN';
        $params['breadcrumbs'] = [
            'DAFTAR STATUS PERMINTAAN' => route(ResourceEnum::ADMIN_STATUS_PERMINTAAN_LIST)
        ];
        $params['row'] = $row;
        $params['model'] = $model;

        return view('status_permintaan_form', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum:ADMIN_STATUS_PERMINTAAN_ENTRY or path '/internal/status-permintaan/entri'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function entry(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $model = new StatusPermintaanForm();
        if ($request->getMethod() === HttpMethodEnum::POST) {
            if ($model->fillAndValidateWith($request)) {
                if(StatusPermintaanModel::exists(['id=' => $model->id])){
                    $model->addError('Id status permintaan sudah digunakan, gunakan id yang lain.');
                }
                if($model->hasError() === false){
                    try {
                        StatusPermintaanModel::create([
                            'id' => $model->id,
                            'nama' => $model->nama,
                            'create_at' => local_time(),
                            'create_by' => auth()->getIdentity()->getId()
                        ]);
                        session()->addFlashSuccess('Data berhasil disimpan');
                    } catch (Exception $e) {
                        session()->addFlashError('Data gagal disimpan. Error:' . $e->getMessage());
                    }
                    return redirect_to(ResourceEnum::ADMIN_STATUS_PERMINTAAN_LIST);
                }
            }
        }
        $params['page'] = 'TAMBAH STATUS PERMINTAAN';
        $params['breadcrumbs'] = [
            'DAFTAR STATUS PERMINTAAN' => route(ResourceEnum::ADMIN_STATUS_PERMINTAAN_LIST)
        ];
        $params['model'] = $model;

        return view('status_permintaan_form', $params, $response, 'backend');
    }
}
