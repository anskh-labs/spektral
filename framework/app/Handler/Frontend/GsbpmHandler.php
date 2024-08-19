<?php

declare(strict_types=1);

namespace App\Handler\Frontend;

use App\Enums\ResourceEnum;
use App\Handler\ActionHandler;
use App\Model\Db\ModulGsbpmModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * GsbpmHandler
 */
class GsbpmHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::GSBPM or path '/gsbpm[/{step}]
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $step = $request->getAttribute('step') ?? 0;
        if ($step < 0 || $step > 8) {
            return redirect_to(ResourceEnum::GSBPM);
        }
        $params['page'] = 'GENERIC STATISTICAL BUSINESS PROCESS MODEL (GSBPM)';
        $params['breadcrumbs'] = [];
        $params['data'] = ModulGsbpmModel::all();
        $params['step'] = $step;

        return view('gsbpm', $params, $response, 'frontend');
    }
}