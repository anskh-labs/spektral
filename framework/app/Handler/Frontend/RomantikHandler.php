<?php

declare(strict_types=1);

namespace App\Handler\Frontend;

use App\Handler\ActionHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * RomantikHandler
 */
class RomantikHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::ROMANTIK or path '/romantik'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $params['page'] = 'PENGAJUAN REKOMENDASI STATISTIK';
        $params['breadcrumbs'] = [];

        return view('romantik', $params, $response, 'frontend');
    }
}