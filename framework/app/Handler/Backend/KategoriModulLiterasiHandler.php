<?php

declare(strict_types=1);

namespace App\Handler\Backend;

use App\Handler\ActionHandler;
use App\Model\Db\KategoriModulLiterasiModel;
use App\Model\Db\ModulLiterasiModel;
use App\Model\Forms\KategoriModulLiterasiForm;
use Faster\Component\Enums\HttpMethodEnum;
use App\Enums\ResourceEnum;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class KategoriModulLiterasiHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_LIST or path '/internal/kategori-modul-literasi'
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
        $params['page'] = 'KATEGORI MODUL LITERASI';
        $params['breadcrumbs'] = [];
        $params['q'] = $q;
        $params['data'] = KategoriModulLiterasiModel::paginate($where, '*');

        return view('kategori_modul_literasi_list', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum:ADMIN_KATEGORI_MODUL_LITERASI_DELETE or path '/internal/kategori-modul-literasi/delete/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $id = $request->getAttribute('id');
            if(ModulLiterasiModel::exists(['kategori=' => $id])){
                session()->addFlashWarning('Kategori modul literasi sedang digunakan sehingga tidak dapat dihapus.');
                return redirect_to(ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_LIST);
            }
            KategoriModulLiterasiModel::delete(['id='=>$id]);
            session()->addFlashSuccess('Hapus kategori modul literasi berhasil.');
        } catch (Exception $e) {
            session()->addFlashError('Gagal hapus kategori modul literasi. Error:' . $e->getMessage());
        }

        return redirect_to(ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_LIST);
    }
    /**
     * Handle route ResourceEnum:ADMIN_KATEGORI_MODUL_LITERASI_EDIT or path '/internal/kategori-modul-literasi/edit/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function edit(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $row = KategoriModulLiterasiModel::row('*', ['id=' => $id]);
        $model = new KategoriModulLiterasiForm(true);
        $model->fill($row);
        if ($request->getMethod() === HttpMethodEnum::POST) {
            if ($model->fillAndValidateWith($request)) {
                try {
                    KategoriModulLiterasiModel::update([
                        'nama' => $model->nama,
                        'deskripsi' => $model->deskripsi,
                        'update_at' => local_time(),
                        'update_by' => auth()->getIdentity()->getId()
                    ], ['id=' => $id]);
                    session()->addFlashSuccess('Data berhasil disimpan');
                } catch (Exception $e) {
                    session()->addFlashError('Data gagal disimpan. Error:' . $e->getMessage());
                }
                return redirect_to(ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_LIST);
            }
        }
        $params['page'] = 'UBAH KATEGORI MODUL LITERASI';
        $params['breadcrumbs'] = [
            'KATEGORI MODUL LITERASI' => route(ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_LIST)
        ];
        $params['row'] = $row;
        $params['model'] = $model;

        return view('kategori_modul_literasi_form', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum:ADMIN_KATEGORI_MODUL_LITERASI_ENTRY or path '/internal/kategori-modul-literasi/entri'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function entry(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $model = new KategoriModulLiterasiForm();
        if ($request->getMethod() === HttpMethodEnum::POST) {
            if ($model->fillAndValidateWith($request)) {
                if(KategoriModulLiterasiModel::exists(['id=' => $model->id])){
                    $model->addError('Id kategori sudah digunakan, gunakan id yang lain.');
                }
                if($model->hasError() === false){
                    try {
                        KategoriModulLiterasiModel::create([
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
                    return redirect_to(ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_LIST);
                }
            }
        }
        $params['page'] = 'TAMBAH KATEGORI MODUL LITERASI';
        $params['breadcrumbs'] = [
            'KATEGORI MODUL LITERASI' => route(ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_LIST)
        ];
        $params['model'] = $model;

        return view('kategori_modul_literasi_form', $params, $response, 'backend');
    }
}
