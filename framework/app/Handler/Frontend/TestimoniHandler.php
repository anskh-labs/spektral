<?php

declare(strict_types=1);

namespace App\Handler\Frontend;

use App\Enums\ResourceEnum;
use App\Handler\ActionHandler;
use App\Model\Db\TestimoniJoinUserModel;
use App\Model\Db\TestimoniModel;
use App\Model\Forms\TestimoniForm;
use Exception;
use Faster\Component\Enums\HttpMethodEnum;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * TestimoniHandler
 */
class TestimoniHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::TESTIMONI or path '/testimoni'
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
            $where = "(`nama` LIKE '%{$q}%' OR `pesan` LIKE '%{$q}%') AND a.is_active=1";
        } else {
            $q = '';
            $where = 'a.is_active=1';
        }
        $model = new TestimoniForm();
        $model->rating = 5; // set default rating
        if ($request->getMethod() === HttpMethodEnum::POST) {
            if(auth()->hasPermission(ResourceEnum::TESTIMONI_POST)){
                if ($model->fillAndValidateWith($request)) {
                    try {
                        TestimoniModel::create(
                            [
                                'pesan' => $model->pesan,
                                'rating' => $model->rating,
                                'is_active' => 1,
                                'create_by' => auth()->getIdentity()->getId(),
                                'create_at' => local_time()
                            ]
                        );
                        session()->addFlashSuccess('Simpan testimoni berhasil');
                    } catch (Exception $e) {
                        session()->addFlashError('Simpan testimoni gagal. Error:' . $e->getMessage());
                    }
                    return redirect_to(ResourceEnum::TESTIMONI);
                }
            }else{
                session()->addFlashWarning('Anda tidak berhak untuk mengirim testimoni.');
                return redirect_to(ResourceEnum::TESTIMONI);
            }
        }
        $params['page'] = 'TESTIMONI PENGGUNA';
        $params['q'] = $q;
        $params['model'] = $model;
        $params['breadcrumbs'] = [];
        $params['data'] = TestimoniJoinUserModel::paginate($where, '*', null, 'a.create_at DESC');

        return view('testimoni', $params, $response, 'frontend');
    }
}