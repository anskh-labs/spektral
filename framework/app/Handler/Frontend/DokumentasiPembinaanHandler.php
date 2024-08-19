<?php

declare(strict_types=1);

namespace App\Handler\Frontend;

use App\Enums\ResourceEnum;
use App\Handler\ActionHandler;
use App\Model\Db\DokumentasiPembinaanJoinUserModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * DokumentasiPembinaanHandler
 */
class DokumentasiPembinaanHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::DOKUMENTASI_PEMBINAAN_LIST or path '/dokumentasi-pembinaan'
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
            $where = "(`judul` LIKE '%{$q}%' OR `berita` LIKE '%{$q}%') AND a.is_active=1";
        } else {
            $q = '';
            $where = 'a.is_active=1';
        }
        $params['page'] = 'DOKUMENTASI PEMBINAAN';
        $params['q'] = $q;
        $params['breadcrumbs'] = [];
        $params['data'] = DokumentasiPembinaanJoinUserModel::paginate($where, '*', null, 'a.tanggal DESC');

        return view('dokumentasi_pembinaan_list', $params, $response, 'frontend');
    }
    /**
     * Handle route ResourceEnum::DOKUMENTASI_PEMBINAAN_VIEW or path '/dokumentasi-pembinaan/view/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function viewDokumentasiPembinaan(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        
        $params['page'] = 'DETAIL DOKUMENTASI PEMBINAAN';
        $params['breadcrumbs'] = [
            'DOKUMENTASI PEMBINAAN' => route(ResourceEnum::DOKUMENTASI_PEMBINAAN_LIST)
        ];
        $params['id'] = $id;
        $params['row'] = DokumentasiPembinaanJoinUserModel::row('*', ['a.id=' => $id, 'a.is_active=' => 1, 'AND']);

        return view('dokumentasi_pembinaan_view', $params, $response, 'frontend');
    }
}