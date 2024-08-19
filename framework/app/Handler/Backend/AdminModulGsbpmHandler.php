<?php

declare(strict_types=1);

namespace App\Handler\Backend;

use App\Enums\ResourceEnum;
use App\Enums\PathEnum;
use App\Handler\ActionHandler;
use App\Model\Db\ModulGsbpmModel;
use App\Model\Forms\GsbpmForm;
use Faster\Component\Enums\HttpMethodEnum;
use Faster\Helper\Service;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

class AdminModulGsbpmHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::ADMIN_MODUL_GSBPM_LIST or path '/internal/modul-gsbpm[/{cat:\d+}]'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $step = $request->getAttribute('step') ?? 0;
        if ($step < 0 || $step > 8) {
            return redirect_to(ResourceEnum::ADMIN_MODUL_GSBPM_LIST);
        }
        $params['page'] = 'GENERIC STATISTICAL BUSINESS PROCESS MODEL (GSBPM)';
        $params['breadcrumbs'] = [];
        $params['data'] = ModulGsbpmModel::all();
        $params['step'] = $step;

        return view('gsbpm_list', $params, $response, 'backend');
    }
    /**
     * Handle route ResourceEnum::ADMIN_MODUL_GSBPM_LIST or path '/internal/modul-gsbpm/edit/{id:\id+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function edit(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params['page'] = 'UBAH DATA';
        $params['breadcrumbs'] = [
            'GENERIC STATISTICAL BUSINESS PROCESS MODEL (GSBPM)' => route(ResourceEnum::ADMIN_MODUL_GSBPM_LIST)
        ];

        $id = $request->getAttribute('id');
        $row = ModulGsbpmModel::row('*', ['id=' => $id]);
        $model = new GsbpmForm(true);
        if ($row) {
            $model->fill($row);
            if ($request->getMethod() === HttpMethodEnum::POST) {
                $post = Service::sanitize($request, 'isi');
                if ($model->fillAndValidate($post)) {
                    foreach ($request->getUploadedFiles() as $file) {
                        if ($file instanceof UploadedFileInterface) {
                            if ($file->getError() === UPLOAD_ERR_OK && $file->getSize() > 0) {
                                $fileExt = strtolower(pathinfo($file->getClientFileName(), PATHINFO_EXTENSION));
                                $allowed_file_ext = ['pdf'];
                                $max_size = app_config('max_upload_size');
                                if ($file->getSize() > $max_size) { 
                                    $mb_size = $max_size / 1000000;
                                    $model->addError("Ukuran file lebih dari {$mb_size}MB.", 'link');
                                } elseif (!in_array($fileExt, $allowed_file_ext)) {
                                    $allowed_file_ext_string = implode(', ', $allowed_file_ext);
                                    $model->addError("Tipe file harus {$allowed_file_ext_string}.", 'link');
                                } else {
                                    try {
                                        $path = ROOT . app_config(PathEnum::GSBPM);
                                        if ($model->link && is_file($path . '/' . $model->link)) {
                                            unlink($path . '/' . $model->link);
                                        }
                                        $model->link = sprintf("%d.{$fileExt}", local_time());
                                        $file->moveTo($path . $model->link);
                                    } catch (Exception $e) {
                                        $model->addError('Upload file gagal. Error:' . $e->getMessage(),  'link');
                                    }
                                }
                            }
                        }
                    }
                    if (!$model->hasError()) {
                        try {
                            ModulGsbpmModel::update(
                                [
                                    'isi' => str_replace('\\','', $post['isi']),
                                    'gambar' => $model->gambar,
                                    'link' => $model->link,
                                    'update_by' => auth()->getIdentity()->getId(),
                                    'update_at' => local_time()
                                ],
                                ['id=' => $id]
                            );
                            session()->addFlashSuccess('Simpan data berhasil');
                        } catch (Exception $e) {
                            session()->addFlashError('Simpan data gagal. Error:' . $e->getMessage());
                        }
                        return redirect_to(ResourceEnum::ADMIN_MODUL_GSBPM_LIST);
                    }
                }
            }
        } else {
            session()->addFlashWarning('Data tidak ditemukan');
            return redirect_to(ResourceEnum::ADMIN_MODUL_GSBPM_LIST);
        }
        $params['id'] = $id;
        $params['model'] = $model;

        return view('gsbpm_form', $params, $response, 'backend');
    }
}
