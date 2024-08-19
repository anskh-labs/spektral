<?php

declare(strict_types=1);

namespace App\Handler\Frontend;

use App\Enums\ResourceEnum;
use App\Handler\ActionHandler;
use App\Model\Db\KategoriModulPembinaanModel;
use App\Model\Db\ModulPembinaanModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * ModulPembinaanHandler
 */
class ModulPembinaanHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::MODUL_PEMBINAAN_LIST or path '/modul-pembinaan[/{cat}]'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $k = $request->getAttribute('cat') ?? 1;
        if (!KategoriModulPembinaanModel::exists(['id=' => $k])) {
            return redirect_to(ResourceEnum::MODUL_PEMBINAAN_LIST);
        }
        $query = $request->getQueryParams();
        if (isset($query['q']) && $query['q']) {
            $q = esc($query['q']);
            $where = "(`nama` LIKE '%{$q}%' OR `deskripsi` LIKE '%{$q}%') AND `kategori`={$k} AND `is_active`=1";
        } else {
            $q = '';
            $where = ['kategori=' => $k, 'is_active=' => 1, 'AND'];
        }

        $params['page'] = 'MODUL PEMBINAAN STATISTIK';
        $params['kategori'] = $k;
        $params['q'] = $q;
        $params['breadcrumbs'] = [];
        $params['data'] = ModulPembinaanModel::paginate($where, '*', 9);
        $params['categories'] = KategoriModulPembinaanModel::all();

        return view('modul_pembinaan_list', $params, $response, 'frontend');
    }
}