<?php

declare(strict_types=1);

namespace App\Handler\Backend;

use App\Handler\ActionHandler;
use App\Model\Db\ModulPembinaanModel;
use App\Model\Db\ModulLiterasiModel;
use App\Model\Db\UserModel;
use App\Model\Db\TestimoniModel;
use App\Model\Db\DokumentasiPembinaanModel;
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
        $params['testimoni'] = TestimoniModel::rekapAktif();
        $params['dokumentasi'] = DokumentasiPembinaanModel::rekapAktif();
        $pengguna = UserModel::rekapbyKategori();
        $params['permintaan'] = PermintaanPembinaanModel::rekapByStatus();
        $params['pembinaan'] = ModulPembinaanModel::rekapByKategori();
        $params['literasi'] = ModulLiterasiModel::rekapByKategori();
        $pengguna_aktif = 0;
        $pengguna_tidak_aktif = 0;
        foreach($pengguna as $row){
            $pengguna_aktif += $row['aktif'];
            $pengguna_tidak_aktif += $row['tidak_aktif'];
        }
        $params['pengguna_aktif'] = $pengguna_aktif;
        $params['pengguna_tidak_aktif'] = $pengguna_tidak_aktif;
        $params['pengguna'] = $pengguna;

        return view('dashboard', $params, $response, 'backend');
    }
}
