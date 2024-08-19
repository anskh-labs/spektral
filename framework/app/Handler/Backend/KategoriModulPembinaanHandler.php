<?php

declare(strict_types=1);

namespace App\Handler\Backend;

use App\Enums\ResourceEnum;
use App\Handler\ActionHandler;
use App\Model\Db\KategoriModulPembinaanModel;
use App\Model\Db\ModulPembinaanModel;
use App\Model\Forms\KategoriModulPembinaanForm;
use Exception;
use Faster\Component\Enums\HttpMethodEnum;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class KategoriModulPembinaanHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_LIST or path '/internal/kategori-modul-pembinaan'
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
        $params['page'] = 'KATEGORI MODUL PEMBINAAN';
        $params['breadcrumbs'] = [];
        $params['q'] = $q;
        $params['data'] = KategoriModulPembinaanModel::paginate($where, '*');

        return view('kategori_modul_pembinaan_list', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum:ADMIN_KATEGORI_MODUL_PEMBINAAN_DELETE or path '/internal/kategori-modul-pembinaan/delete/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $id = $request->getAttribute('id');
            if(ModulPembinaanModel::exists(['kategori=' => $id])){
                session()->addFlashWarning('Kategori modul pembinaan sedang digunakan sehingga tidak dapat dihapus.');
                return redirect_to(ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_LIST);
            }
            KategoriModulPembinaanModel::delete(['id='=>$id]);
            session()->addFlashSuccess('Hapus kategori modul pembinaan berhasil.');
        } catch (Exception $e) {
            session()->addFlashError('Gagal hapus kategori modul pembinaan. Error:' . $e->getMessage());
        }

        return redirect_to(ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_LIST);
    }
    /**
     * Handle route ResourceEnum:ADMIN_KATEGORI_MODUL_PEMBINAAN_EDIT or path '/internal/kategori-modul-pembinaan/edit/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function edit(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $row = KategoriModulPembinaanModel::row('*', ['id=' => $id]);
        $model = new KategoriModulPembinaanForm(true);
        $model->fill($row);
        if ($request->getMethod() === HttpMethodEnum::POST) {
            if ($model->fillAndValidateWith($request)) {
                try {
                    KategoriModulPembinaanModel::update([
                        'nama' => $model->nama,
                        'deskripsi' => $model->deskripsi,
                        'update_at' => local_time(),
                        'update_by' => auth()->getIdentity()->getId()
                    ], ['id=' => $id]);
                    session()->addFlashSuccess('Data berhasil disimpan');
                } catch (Exception $e) {
                    session()->addFlashError('Data gagal disimpan. Error:' . $e->getMessage());
                }
                return redirect_to(ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_LIST);
            }
        }
        $params['page'] = 'UBAH KATEGORI MODUL PEMBINAAN';
        $params['breadcrumbs'] = [
            'KATEGORI MODUL PEMBINAAN' => route(ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_LIST)
        ];
        $params['row'] = $row;
        $params['model'] = $model;

        return view('kategori_modul_pembinaan_form', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum:ADMIN_KATEGORI_MODUL_PEMBINAAN_ENTRY or path '/internal/kategori-modul-pembinaan/entri'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function entry(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $model = new KategoriModulPembinaanForm();
        if ($request->getMethod() === HttpMethodEnum::POST) {
            if ($model->fillAndValidateWith($request)) {
                if(KategoriModulPembinaanModel::exists(['id=' => $model->id])){
                    $model->addError('Id kategori sudah digunakan, gunakan id yang lain.');
                }
                if($model->hasError() === false){
                    try {
                        KategoriModulPembinaanModel::create([
                            'id' => $model->id,
                            'nama' => $model->nama,
                            'deskripsi' => $model->deskripsi,
                            'create_at' => local_time(),
                            'create_by' => auth()->getIdentity()->getId()
                        ]);
                        session()->addFlashSuccess('Data berhasil disimpan');
                    } catch (Exception $e) {
                        session()->addFlashError('Data gagal disimpan. Error:' . $e->getMessage());
                    }
                    return redirect_to(ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_LIST);
                }
            }
        }
        $params['page'] = 'TAMBAH KATEGORI MODUL PEMBINAAN';
        $params['breadcrumbs'] = [
            'KATEGORI MODUL PEMBINAAN' => route(ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_LIST)
        ];
        $params['model'] = $model;

        return view('kategori_modul_pembinaan_form', $params, $response, 'backend');
    }
}
