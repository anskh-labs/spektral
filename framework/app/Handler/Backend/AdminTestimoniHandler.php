<?php

declare(strict_types=1);

namespace App\Handler\Backend;

use App\Enums\ResourceEnum;
use App\Handler\ActionHandler;
use App\Model\Db\TestimoniJoinUserModel;
use App\Model\Db\TestimoniModel;
use App\Model\Forms\EditTestimoniForm;
use Exception;
use Faster\Component\Enums\HttpMethodEnum;
use Faster\Helper\Service;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminTestimoniHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::ADMIN_TESTIMONI_LIST or path '/internal/testimoni'
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
            $where = "`nama` LIKE '%{$q}%' or `pesan` LIKE '%{$q}%'";
        } else {
            $q = null;
            $where = null;
        }
        $params['page'] = 'DAFTAR TESTIMONI PENGGUNA';
        $params['breadcrumbs'] = [];
        $params['q'] = $q;
        $params['data'] = TestimoniJoinUserModel::paginate($where, '*', null, 'create_at DESC');

        return view('testimoni_list', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum::ADMIN_TESTIMONI_EDIT or path '/internal/testimoni/edit/{id:\id+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function edit(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $row = TestimoniJoinUserModel::row('*', ['a.id=' => $id]);
        $model = new EditTestimoniForm(true);
        if (!$row) {
            session()->addFlashWarning('Data testimoni tidak ditemukan');
            return redirect_to(ResourceEnum::ADMIN_TESTIMONI_LIST);
        }
        $model->is_active = $row['is_active'];
        if ($request->getMethod() === HttpMethodEnum::POST) {
            $post = Service::sanitize($request);
            $post['is_active'] = isset($post['is_active']) ? 1 : 0;
            if ($model->fillAndValidate($post)) {
                try {
                    TestimoniModel::update(
                        [
                            'is_active' => $model->is_active,
                            'update_at' => local_time()
                        ],
                        ['id=' => $id]
                    );
                    session()->addFlashSuccess('Simpan testimoni berhasil');
                } catch (Exception $e) {
                    session()->addFlashError('Simpan testimoni gagal. Error:' . $e->getMessage());
                }
                return redirect_to(ResourceEnum::ADMIN_TESTIMONI_LIST);
            }
        }
        $params['page'] = 'UBAH TESTIMONI PENGGUNA';
        $params['breadcrumbs'] = [
            'DAFTAR TESTIMONI PENGGUNA' => route(ResourceEnum::ADMIN_TESTIMONI_LIST)
        ];
        $params['id'] = $id;
        $params['model'] = $model;
        $params['row'] = $row;

        return view('testimoni_form', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum::ADMIN_TESTIMONI_DELETE or path '/internal/testimoni/delete/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $row = TestimoniModel::row('*', ['id=' => $id]);
        if ($row) {
            try {
                TestimoniModel::delete(['id=' => $id]);
                session()->addFlashSuccess('Hapus testimoni berhasil.');
            } catch (Exception $e) {
                session()->addFlashError('Hapus testimoni gagal. Error:' . $e->getMessage());
            }
        }

        return redirect_to(ResourceEnum::ADMIN_TESTIMONI_LIST);
    }
}
