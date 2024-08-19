<?php

declare(strict_types=1);

namespace App\Handler\Backend;

use App\Handler\ActionHandler;
use App\Model\Db\ModulPembinaanModel;
use App\Model\Db\ModulLiterasiModel;
use App\Model\Db\UserModel;
use App\Model\Db\PermintaanPembinaanModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DashboardHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::DASHBOARD or path '/internal'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $params['page'] = 'BERANDA';
        $params['modul_pembinaan'] = ModulPembinaanModel::rekapAktif();
        $params['modul_literasi'] = ModulLiterasiModel::rekapAktif();
        $params['pengguna'] = UserModel::rekapAktif();

        return view('dashboard', $params, $response, 'backend');
    }
}
