<?php

declare(strict_types=1);

namespace App\Handler\Backend;

use App\Enums\ResourceEnum;
use App\Handler\ActionHandler;
use App\Model\Db\TingkatInstansiModel;
use App\Model\Db\UserModel;
use App\Model\Forms\TingkatInstansiForm;
use Exception;
use Faster\Component\Enums\HttpMethodEnum;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TingkatInstansiHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::ADMIN_TINGKAT_INSTANSI_LIST or path '/internal/tingkat-instansi'
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
        $params['page'] = 'DAFTAR TINGKAT INSTANSI';
        $params['breadcrumbs'] = [];
        $params['q'] = $q;
        $params['data'] = TingkatInstansiModel::paginate($where, '*');

        return view('tingkat_instansi_list', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum:ADMIN_TINGKAT_INSTANSI_DELETE or path '/internal/tingkat-instansi/delete/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $id = $request->getAttribute('id');
            if(UserModel::exists(['tingkat=' => $id])){
                session()->addFlashWarning('Tingkat instansi sedang digunakan sehingga tidak dapat dihapus.');
                return redirect_to(ResourceEnum::ADMIN_TINGKAT_INSTANSI_LIST);
            }
            TingkatInstansiModel::delete(['id='=>$id]);
            session()->addFlashSuccess('Hapus tingkat instansi berhasil.');
        } catch (Exception $e) {
            session()->addFlashError('Gagal hapus tingkat instansi. Error:' . $e->getMessage());
        }

        return redirect_to(ResourceEnum::ADMIN_TINGKAT_INSTANSI_LIST);
    }
    /**
     * Handle route ResourceEnum:ADMIN_TINGKAT_INSTANSI_EDIT or path '/internal/tingkat-instansi/edit/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function edit(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $row = TingkatInstansiModel::row('*', ['id=' => $id]);
        $model = new TingkatInstansiForm(true);
        $model->fill($row);
        if ($request->getMethod() === HttpMethodEnum::POST) {
            if ($model->fillAndValidateWith($request)) {
                try {
                    TingkatInstansiModel::update([
                        'nama' => $model->nama,
                        'update_at' => local_time(),
                        'update_by' => auth()->getIdentity()->getId()
                    ], ['id=' => $id]);
                    session()->addFlashSuccess('Data berhasil disimpan');
                } catch (Exception $e) {
                    session()->addFlashError('Data gagal disimpan. Error:' . $e->getMessage());
                }
                return redirect_to(ResourceEnum::ADMIN_TINGKAT_INSTANSI_LIST);
            }
        }
        $params['page'] = 'UBAH TINGKAT INSTANSI';
        $params['breadcrumbs'] = [
            'DAFTAR TINGKAT INSTANSI' => route(ResourceEnum::ADMIN_TINGKAT_INSTANSI_LIST)
        ];
        $params['row'] = $row;
        $params['model'] = $model;

        return view('tingkat_instansi_form', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum:ADMIN_TINGKAT_INSTANSI_ENTRY or path '/internal/tingkat-instansi/entri'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function entry(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $model = new TingkatInstansiForm();
        if ($request->getMethod() === HttpMethodEnum::POST) {
            if ($model->fillAndValidateWith($request)) {
                if(TingkatInstansiModel::exists(['id=' => $model->id])){
                    $model->addError('Id tingkat instansi sudah digunakan, gunakan id yang lain.');
                }
                if($model->hasError() === false){
                    try {
                        TingkatInstansiModel::create([
                            'id' => $model->id,
                            'nama' => $model->nama,
                            'create_at' => local_time(),
                            'create_by' => auth()->getIdentity()->getId()
                        ]);
                        session()->addFlashSuccess('Data berhasil disimpan');
                    } catch (Exception $e) {
                        session()->addFlashError('Data gagal disimpan. Error:' . $e->getMessage());
                    }
                    return redirect_to(ResourceEnum::ADMIN_TINGKAT_INSTANSI_LIST);
                }
            }
        }
        $params['page'] = 'TAMBAH TINGKAT INSTANSI';
        $params['breadcrumbs'] = [
            'DAFTAR TINGKAT INSTANSI' => route(ResourceEnum::ADMIN_TINGKAT_INSTANSI_LIST)
        ];
        $params['model'] = $model;

        return view('tingkat_instansi_form', $params, $response, 'backend');
    }
}
