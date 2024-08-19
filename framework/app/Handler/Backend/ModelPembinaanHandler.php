<?php

declare(strict_types=1);

namespace App\Handler\Backend;

use App\Enums\ResourceEnum;
use App\Handler\ActionHandler;
use App\Model\Db\PermintaanPembinaanModel;
use App\Model\Db\ModelPembinaanModel;
use App\Model\Forms\ModelPembinaanForm;
use Exception;
use Faster\Component\Enums\HttpMethodEnum;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ModelPembinaanHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::ADMIN_MODEL_PEMBINAAN_LIST or path '/internal/model-pembinaan'
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
        $params['page'] = 'DAFTAR MODEL PEMBINAAN';
        $params['breadcrumbs'] = [];
        $params['q'] = $q;
        $params['data'] = ModelPembinaanModel::paginate($where, '*');

        return view('model_pembinaan_list', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum:ADMIN_MODEL_PEMBINAAN_DELETE or path '/internal/model-pembinaan/delete/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $id = $request->getAttribute('id');
            if(PermintaanPembinaanModel::exists(['model_pembinaan=' => $id])){
                session()->addFlashWarning('Model pembinaan sedang digunakan sehingga tidak dapat dihapus.');
                return redirect_to(ResourceEnum::ADMIN_MODEL_PEMBINAAN_LIST);
            }
            ModelPembinaanModel::delete(['id='=>$id]);
            session()->addFlashSuccess('Hapus model pembinaan berhasil.');
        } catch (Exception $e) {
            session()->addFlashError('Gagal hapus model pembinaan. Error:' . $e->getMessage());
        }

        return redirect_to(ResourceEnum::ADMIN_MODEL_PEMBINAAN_LIST);
    }
    /**
     * Handle route ResourceEnum:ADMIN_MODEL_PEMBINAAN_EDIT or path '/internal/model-pembinaan/edit/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function edit(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $row = ModelPembinaanModel::row('*', ['id=' => $id]);
        $model = new ModelPembinaanForm(true);
        $model->fill($row);
        if ($request->getMethod() === HttpMethodEnum::POST) {
            if ($model->fillAndValidateWith($request)) {
                try {
                    ModelPembinaanModel::update([
                        'nama' => $model->nama,
                        'update_at' => local_time(),
                        'update_by' => auth()->getIdentity()->getId()
                    ], ['id=' => $id]);
                    session()->addFlashSuccess('Data berhasil disimpan');
                } catch (Exception $e) {
                    session()->addFlashError('Data gagal disimpan. Error:' . $e->getMessage());
                }
                return redirect_to(ResourceEnum::ADMIN_MODEL_PEMBINAAN_LIST);
            }
        }
        $params['page'] = 'UBAH MODEL PEMBINAAN';
        $params['breadcrumbs'] = [
            'DAFTAR MODEL PEMBINAAN' => route(ResourceEnum::ADMIN_MODEL_PEMBINAAN_LIST)
        ];
        $params['row'] = $row;
        $params['model'] = $model;

        return view('model_pembinaan_form', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum:ADMIN_MODEL_PEMBINAAN_ENTRY or path '/internal/model-pembinaan/entri'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function entry(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $model = new ModelPembinaanForm();
        if ($request->getMethod() === HttpMethodEnum::POST) {
            if ($model->fillAndValidateWith($request)) {
                if(ModelPembinaanModel::exists(['id=' => $model->id])){
                    $model->addError('Id model pembinaan sudah digunakan, gunakan id yang lain.');
                }
                if($model->hasError() === false){
                    try {
                        ModelPembinaanModel::create([
                            'id' => $model->id,
                            'nama' => $model->nama,
                            'create_at' => local_time(),
                            'create_by' => auth()->getIdentity()->getId()
                        ]);
                        session()->addFlashSuccess('Data berhasil disimpan');
                    } catch (Exception $e) {
                        session()->addFlashError('Data gagal disimpan. Error:' . $e->getMessage());
                    }
                    return redirect_to(ResourceEnum::ADMIN_MODEL_PEMBINAAN_LIST);
                }
            }
        }
        $params['page'] = 'TAMBAH MODEL PEMBINAAN';
        $params['breadcrumbs'] = [
            'DAFTAR MODEL PEMBINAAN' => route(ResourceEnum::ADMIN_MODEL_PEMBINAAN_LIST)
        ];
        $params['model'] = $model;

        return view('model_pembinaan_form', $params, $response, 'backend');
    }
}
