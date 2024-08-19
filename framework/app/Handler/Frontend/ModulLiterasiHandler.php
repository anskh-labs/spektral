<?php

declare(strict_types=1);

namespace App\Handler\Frontend;

use App\Enums\ResourceEnum;
use App\Handler\ActionHandler;
use App\Model\Db\KategoriModulLiterasiModel;
use App\Model\Db\ModulLiterasiModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * ModulLiterasiHandler
 */
class ModulLiterasiHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::MODUL_LITERASI_LIST or path '/modul-literasi[/{cat}]'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $k = $request->getAttribute('cat') ?? 1;
        if (!KategoriModulLiterasiModel::exists(['id=' => $k])) {
            return redirect_to(ResourceEnum::MODUL_LITERASI_LIST);
        }
        $query = $request->getQueryParams();
        if (isset($query['q']) && $query['q']) {
            $q = esc($query['q']);
            $where = "(`nama` LIKE '%{$q}%' OR `deskripsi` LIKE '%{$q}%') AND `kategori`={$k} AND `is_active`=1";
        } else {
            $q = '';
            $where = ['kategori=' => $k, 'is_active=' => 1, 'AND'];
        }

        $params['page'] = 'MODUL LITERASI STATISTIK';
        $params['kategori'] = $k;
        $params['q'] = $q;
        $params['breadcrumbs'] = [];
        $params['data'] = ModulLiterasiModel::paginate($where, '*', 9);
        $params['categories'] = KategoriModulLiterasiModel::all();

        return view('modul_literasi_list', $params, $response, 'frontend');
    }
}