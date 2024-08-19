<?php

declare(strict_types=1);

namespace App\Handler\Backend;

use App\Enums\ResourceEnum;
use App\Handler\ActionHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminRoleHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::ADMIN_ROLE_LIST or path '/internal/user-role'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $params['page'] = 'DAFTAR ROLE';
        $params['breadcrumbs'] = [
            'DAFTAR PENGGUNA' => route(ResourceEnum::ADMIN_USER_LIST)
        ];
        $params['data'] = config('permissions');

        return view('user_role', $params, $response, 'backend');
    }
}
