<?php

declare(strict_types=1);

namespace App\Handler\Backend;

use App\Enums\ResourceEnum;
use App\Handler\ActionHandler;
use App\Model\Db\TestimoniModel;
use App\Model\Db\UserJoinTingkatInstansiModel;
use App\Model\Db\UserModel;
use App\Model\Forms\EditUserForm;
use App\Model\Forms\UserForm;
use Exception;
use Faster\Component\Enums\HttpMethodEnum;
use Faster\Helper\Service;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminUserHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::ADMIN_USER_LIST or path '/internal/user'
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
            $where = "(`nama` LIKE '%{$q}%' OR `email` LIKE '%{$q}%')";
        } else {
            $q = null;
            $where = null;
        }
        $params['page'] = 'DAFTAR PENGGUNA';
        $params['breadcrumbs'] = [];
        $params['q'] = $q;
        $params['data'] = UserModel::paginate($where, '*');

        return view('user_list', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum:ADMIN_USER_INFO or path '/internal/account/info'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function infoUser(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params['breadcrumbs'] = [];
        $params['page'] = 'INFORMASI PENGGUNA';
        $params['model'] = new UserForm();
        $params['row'] = UserJoinTingkatInstansiModel::row('*', ['a.id=' => auth()->getIdentity()->getId()]);

        return view('user_info', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum:ADMIN_USER_DELETE or path '/internal/user/delete/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function deleteUser(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $id = $request->getAttribute('id');
            TestimoniModel::delete(['create_by=' => $id]);
            UserModel::delete(['id=' => $id]);
            session()->addFlashSuccess('Hapus data pengguna berhasil.');
        } catch (Exception $e) {
            session()->addFlashError('Gagal hapus data pengguna.Error:' . $e->getMessage());
        }

        return redirect_to(ResourceEnum::ADMIN_USER_LIST);
    }
    /**
     * Handle route ResourceEnum:ADMIN_USER_VIEW or path '/internal/user/view/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function viewUser(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $params['breadcrumbs'] = [
            'DAFTAR PENGGUNA' => route(ResourceEnum::ADMIN_USER_LIST)
        ];
        $params['page'] = 'INFORMASI PENGGUNA';
        $params['row'] = UserJoinTingkatInstansiModel::row('*', ['a.id=' => $id]);
        return view('user_view', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum:ADMIN_USER_EDIT or path '/internal/user/edit/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function editUser(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $row = UserJoinTingkatInstansiModel::row('*', ['a.id=' => $id]);
        if (!$row) {
            session()->addFlashWarning('Data pengguna tidak ditemukan');
            return redirect_to(ResourceEnum::ADMIN_USER_LIST);
        }
        $model = new EditUserForm();
        $model->fill($row);
        if ($request->getMethod() == HttpMethodEnum::POST) {
            $post = Service::sanitize($request);
            $post['is_active'] = isset($post['is_active']) ? 1 : 0;
            if(is_internal($row['email'])){
                $post['role'] = is_array($post['roles'] ?? '') ? implode(',', $post['roles']) : '';
            }else{
                $post['role'] = $model->role;
            }

            if ($model->fillAndValidate($post)) {
                try {
                    UserModel::update([
                        'is_active' => $model->is_active,
                        'role' => $model->role,
                        'update_at' => local_time()
                    ], ['id=' => $id]);
                    session()->addFlashSuccess('Data berhasil disimpan');
                } catch (Exception $e) {
                    session()->addFlashError('Data gagal disimpan. Error:' . $e->getMessage());
                }
                return redirect_to(ResourceEnum::ADMIN_USER_LIST);
            }
        }
        $params['page'] = 'UBAH DATA PENGGUNA';
        $params['breadcrumbs'] = [
            'DAFTAR PENGGUNA' => route(ResourceEnum::ADMIN_USER_LIST)
        ];
        $params['row'] = $row;
        $params['model'] = $model;

        return view('user_edit', $params, $response, 'backend');
    }
}
