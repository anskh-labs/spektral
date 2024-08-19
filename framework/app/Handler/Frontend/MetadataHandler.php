<?php

declare(strict_types=1);

namespace App\Handler\Frontend;

use App\Handler\ActionHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * MetadataHandler
 */
class MetadataHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::METADATA or path '/metadata'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $params['page'] = 'PELAPORAN METADATA STATISTIK';
        $params['breadcrumbs'] = [];

        return view('metadata', $params, $response, 'frontend');
    }
}