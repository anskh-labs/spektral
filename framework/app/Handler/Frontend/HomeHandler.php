<?php

declare(strict_types=1);

namespace App\Handler\Frontend;

use App\Handler\ActionHandler;
use App\Model\Db\KategoriModulLiterasiModel;
use App\Model\Db\KategoriModulPembinaanModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * HomeHandler
 */
class HomeHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::HOME or path '/'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $params['page'] = 'BERANDA';
        $params['kategori_pembinaan'] = KategoriModulPembinaanModel::all();
        $params['kategori_literasi'] = KategoriModulLiterasiModel::all();

        return view('index', $params, $response, 'frontend');
    }
    /**
     * Handle route ResourceEnum::MAINTENANCE or path '/maintenance'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function maintenance(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params['page'] = 'MAINTENANCE';

        return render('maintenance', $params, $response);
    }
}