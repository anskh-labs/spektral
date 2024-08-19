<?php

declare(strict_types=1);

namespace App\Handler\Frontend;

use App\Enums\PathEnum;
use App\Enums\ResourceEnum;
use App\Enums\RoleEnum;
use App\Enums\StatusPermintaanEnum;
use App\Handler\ActionHandler;
use App\Helper\Service;
use App\Model\Db\DokumentasiPembinaanModel;
use App\Model\Db\ModelPembinaanModel;
use App\Model\Db\PermintaanPembinaanJoinModel;
use App\Model\Db\PermintaanPembinaanModel;
use App\Model\Db\PesanPermintaanJoinUserModel;
use App\Model\Db\PesanPermintaanModel;
use App\Model\Db\UserJoinTingkatInstansiModel;
use App\Model\Db\UserModel;
use App\Model\Forms\PermintaanPembinaanForm;
use App\Model\Forms\PesanPermintaanForm;
use Exception;
use Faster\Component\Enums\HttpMethodEnum;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

class PermintaanPembinaanHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::PERMINTAAN_PEMBINAAN_LIST or path '/permintaan-pembinaan'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    { 
        $query = $request->getQueryParams();
        $id = auth()->getIdentity()->getId();
        if (isset($query['q']) && $query['q']) {
            $q = esc($query['q']);
            $where = "a.deskripsi LIKE '%{$q}%' and a.create_by='{$id}'";
        } else {
            $q = null;
            $where = ['a.create_by=' => "$id"];
        }
        $params['page'] = 'DAFTAR PERMINTAAN PEMBINAAN SAYA';
        $params['breadcrumbs'] = [];
        $params['q'] = $q;
        $params['data'] = PermintaanPembinaanJoinModel::paginate($where, '*');

        return view('permintaan_pembinaan_list', $params, $response, 'frontend');
    }

    /**
     * Handle route ResourceEnum::PERMINTAAN_PEMBINAAN_ENTRY or path '/permintaan-pembinaan/entri'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function entryPermintaanPembinaan(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $model = new PermintaanPembinaanForm();
        $model->produsen_data = 1; // set default as instansi produsen data
        $model->nama_pic = auth()->getIdentity()->getData()['nama'];
        $model->email_pic = auth()->getIdentity()->getData()['email'];
        $model->hp_pic = auth()->getIdentity()->getData()['hp'];
        if ($request->getMethod() === HttpMethodEnum::POST) {
            if ($model->fillAndValidateWith($request)) {
                if ($model->tanggal <= date("Y-m-d")) {
                    $model->addError("Tanggal harus lebih dari sekarang.", 'tanggal');
                } else {
                    foreach ($request->getUploadedFiles() as $file) {
                        if ($file instanceof UploadedFileInterface) {
                            if ($file->getError() === UPLOAD_ERR_OK && $file->getSize() > 0) {
                                $fileExt = strtolower(pathinfo($file->getClientFileName(), PATHINFO_EXTENSION));
                                $allowed_file_ext = ['pdf'];
                                $max_size = app_config('max_upload_size');
                                if ($file->getSize() > $max_size) { 
                                    $mb_size = $max_size / 1000000;
                                    $model->addError("Ukuran file lebih dari {$mb_size}MB.", 'surat');
                                } elseif (!in_array($fileExt, $allowed_file_ext)) {
                                    $allowed_file_ext_string = implode(', ', $allowed_file_ext);
                                    $model->addError("Tipe file harus {$allowed_file_ext_string}.", 'surat');
                                } else {
                                    try {
                                        $model->surat = sprintf('%d.pdf', local_time());
                                        $path = ROOT . app_config(PathEnum::PERMINTAAN_PEMBINAAN);
                                        $file->moveTo($path . '/' . $model->surat);
                                    } catch (\Exception $e) {
                                        $model->addError('Upload file surat pengantar gagal. Error:' . $e->getMessage(),  'link');
                                    }
                                }
                            }
                        }
                    }
                }
                if (!$model->hasError() && $model->surat) {
                    $mail = Service::mailer(true);
                    try {
                        $mail->setFrom('ipds1400@bps.go.id', 'Noreply SPEKTRAL BPS Provinsi Riau');
                        $mail->addAddress(auth()->getIdentity()->getData()['email']);
                        $mail->addReplyTo('bps1400@bps.go.id', 'BPS Provinsi Riau');

                        $mail->isHTML(true);
                        $template = template_config('new_ticket');
                        $mail->Subject = $template['subject'];
                        $message = str_replace('%client_name%', auth()->getIdentity()->getData()['nama'] ?? 'Pengguna', $template['html_message']);
                        $message = str_replace('%client_url%', base_url(route(ResourceEnum::PERMINTAAN_PEMBINAAN_LIST)), $message);
                        $mail->Body    = $message;

                        $mail->send();

                        PermintaanPembinaanModel::create(
                            [
                                'produsen_data' => $model->produsen_data,
                                'deskripsi' => $model->deskripsi,
                                'model_pembinaan' => $model->model_pembinaan,
                                'tanggal' => $model->tanggal,
                                'waktu' => $model->waktu,
                                'lokasi' => $model->lokasi,
                                'surat' => $model->surat,
                                'nama_pic' => $model->nama_pic,
                                'hp_pic' => $model->hp_pic,
                                'email_pic' => $model->email_pic,
                                'status' => StatusPermintaanEnum::OPEN,
                                'create_by' => auth()->getIdentity()->getId(),
                                'create_at' => local_time()
                            ]
                        );
                        session()->addFlashSuccess('Simpan permintaan pembinaan berhasil');

                        $mail->clearAddresses();
                        $super = UserModel::whereRole(RoleEnum::SUPERVISOR);

                        if ($super) {
                            foreach ($super as $address) {
                                $mail->addAddress($address);
                            }
                            $template = template_config('new_ticket_notification');
                            $mail->Subject = $template['subject'];
                            $message = str_replace('%client_url%', base_url(route(ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_LIST)), $template['html_message']);
                            $mail->Body = $message;

                            $mail->send();
                        }
                    } catch (\Exception $e) {
                        if ($mail->ErrorInfo) {
                            session()->addFlashError("Terdapat kesalahan dalam pengiriman email. Error: {$mail->ErrorInfo}");
                        }
                        session()->addFlashError("Simpan permintaan pembinaan gagal");
                    }
                    return redirect_to(ResourceEnum::PERMINTAAN_PEMBINAAN_LIST);
                }
            }
        }
        $params['page'] = 'PERMINTAAN BARU';
        $params['breadcrumbs'] = [
            'DAFTAR PERMINTAAN PEMBINAAN SAYA' => route(ResourceEnum::PERMINTAAN_PEMBINAAN_LIST)
        ];
        $params['model'] = $model;
        $params['data'] = UserJoinTingkatInstansiModel::row('*', ['a.id=' => auth()->getIdentity()->getId()]);
        $params['listJenis'] = ModelPembinaanModel::all();

        return view('permintaan_pembinaan_form', $params, $response, 'frontend');
    }
    /**
     * Handle route ResourceEnum::PERMINTAAN_PEMBINAAN_VIEW or path '/permintaan-pembinaan/view/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function viewPermintaanPembinaan(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $row = PermintaanPembinaanJoinModel::row('*', ['a.id=' => $id]);
        if ($row) {
            if ($row['create_by'] != auth()->getIdentity()->getId()) {
                session()->addFlashWarning('Anda tidak berhak untuk mengakses data tersebut.');
                return redirect_to(ResourceEnum::PERMINTAAN_PEMBINAAN_LIST);
            }
        } else {
            session()->addFlashWarning('Data tidak ditemukan.');
            return redirect_to(ResourceEnum::PERMINTAAN_PEMBINAAN_LIST);
        }
        $model = new PesanPermintaanForm();
        if ($request->getMethod() === HttpMethodEnum::POST) {
            if (auth()->hasPermission(ResourceEnum::PESAN_PERMINTAAN_PEMBINAAN_POST)) {
                if ($model->fillAndValidateWith($request)) {
                    try {
                        PesanPermintaanModel::create(
                            [
                                'permintaan_id' => $id,
                                'waktu' => local_time(),
                                'user_id' => auth()->getIdentity()->getId(),
                                'pesan' => $model->pesan
                            ]
                        );
                        session()->addFlashSuccess('Kirim pesan berhasil');
                    } catch (Exception $e) {
                        session()->addFlashError('Kirim pesan gagal. Error:' . $e->getMessage());
                    }
                    return redirect_to(ResourceEnum::PERMINTAAN_PEMBINAAN_VIEW, strval($id));
                }
            } else {
                session()->addFlashWarning('Anda tidak berhak untuk mengisi percakapan.');
                return redirect_to(ResourceEnum::PERMINTAAN_PEMBINAAN_VIEW, strval($id));
            }
        }
        $params['page'] = 'DETAIL PERMINTAAN PEMBINAAN';
        $params['breadcrumbs'] = [
            'DAFTAR PERMINTAAN PEMBINAAN SAYA' => route(ResourceEnum::PERMINTAAN_PEMBINAAN_LIST)
        ];
        $params['id'] = $id;
        $params['row'] = $row;
        $params['model'] = $model;
        $params['messages'] = PesanPermintaanJoinUserModel::find(['permintaan_id=' => $id], '*', 0, -1, 'a.id ASC');

        return view('permintaan_pembinaan_view', $params, $response, 'frontend');
    }
    /**
     * Handle route ResourceEnum::PERMINTAAN_PEMBINAAN_EDIT or path '/permintaan-pembinaan/edit/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function editPermintaanPembinaan(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $row = PermintaanPembinaanJoinModel::row('*', ['a.id=' => $id]);
        if ($row) {
            if ($row['create_by'] != auth()->getIdentity()->getId()) {
                session()->addFlashWarning('Anda tidak berhak untuk mengakses data tersebut.');
                return redirect_to(ResourceEnum::PERMINTAAN_PEMBINAAN_LIST);
            }
            if (ticket_readonly($row['status'])) {
                session()->addFlashWarning('Data sudah tidak dapat diubah.');
                return redirect_to(ResourceEnum::PERMINTAAN_PEMBINAAN_LIST);
            }
        } else {
            session()->addFlashWarning('Data tidak ditemukan.');
            return redirect_to(ResourceEnum::PERMINTAAN_PEMBINAAN_LIST);
        }

        $model = new PermintaanPembinaanForm(true);
        $model->fill($row);
        if ($request->getMethod() === HttpMethodEnum::POST) {
            $data = Service::sanitize($request);
            $data['produsen_data'] = isset($data['produsen_data']) ? 1 : 0;
            if ($model->fillAndValidate($data)) {
                if ($model->tanggal <= date("Y-m-d")) {
                    $model->addError("Tanggal harus lebih dari sekarang.", 'tanggal');
                } else {
                    foreach ($request->getUploadedFiles() as $file) {
                        if ($file instanceof UploadedFileInterface) {
                            if ($file->getError() === UPLOAD_ERR_OK && $file->getSize() > 0) {
                                $fileExt = strtolower(pathinfo($file->getClientFileName(), PATHINFO_EXTENSION));
                                $allowed_file_ext = ['pdf'];
                                $max_size = app_config('max_upload_size');
                                if ($file->getSize() > $max_size) { 
                                    $mb_size = $max_size / 1000000;
                                    $model->addError("Ukuran file lebih dari {$mb_size}MB.", 'surat');
                                } elseif (!in_array($fileExt, $allowed_file_ext)) {
                                    $allowed_file_ext_string = implode(', ', $allowed_file_ext);
                                    $model->addError("Tipe file harus {$allowed_file_ext_string}.", 'surat');
                                } else {
                                    try {
                                        $path = ROOT . app_config(PathEnum::PERMINTAAN_PEMBINAAN);
                                        if ($model->surat && is_file($path . '/' . $model->surat)) {
                                            unlink($path . '/' . $model->surat);
                                        }
                                        $model->surat = sprintf('%d.pdf', local_time());
                                        $file->moveTo($path . $model->surat);
                                    } catch (Exception $e) {
                                        $model->addError('Upload file surat pengantar gagal. Error:' . $e->getMessage(),  'link');
                                    }
                                }
                            }
                        }
                    }
                }
                if (!$model->hasError()) {
                    try {
                        PermintaanPembinaanModel::update(
                            [
                                'produsen_data' => $model->produsen_data,
                                'deskripsi' => $model->deskripsi,
                                'model_pembinaan' => $model->model_pembinaan,
                                'tanggal' => $model->tanggal,
                                'waktu' => $model->waktu,
                                'lokasi' => $model->lokasi,
                                'surat' => $model->surat,
                                'nama_pic' => $model->nama_pic,
                                'hp_pic' => $model->hp_pic,
                                'email_pic' => $model->email_pic,
                                'update_at' => local_time()
                            ],
                            [
                                'id=' => $id
                            ]
                        );
                        session()->addFlashSuccess('Simpan permintaan pembinaan berhasil');
                    } catch (Exception $e) {
                        session()->addFlashError('Simpan permintaan pembinaan gagal. Error:' . $e->getMessage());
                    }
                    return redirect_to(ResourceEnum::PERMINTAAN_PEMBINAAN_LIST);
                }
            }
        }
        $params['page'] = 'UBAH PERMINTAAN PEMBINAAN';
        $params['breadcrumbs'] = [
            'DAFTAR PERMINTAAN PEMBINAAN SAYA' => route(ResourceEnum::PERMINTAAN_PEMBINAAN_LIST)
        ];
        $params['id'] = $id;
        $params['model'] = $model;
        $params['data'] = UserJoinTingkatInstansiModel::row('*', ['a.id=' => auth()->getIdentity()->getId()]);
        $params['listJenis'] = ModelPembinaanModel::all();

        return view('permintaan_pembinaan_form', $params, $response, 'frontend');
    }
    /**
     * Handle route ResourceEnum::PERMINTAAN_PEMBINAAN_DELETE or path '/permintaan-pembinaan/delete/{id:\d+}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function deletePermintaanPembinaan(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $row = PermintaanPembinaanModel::row('*', ['id=' => $id]);
        if ($row) {
            $filename = $row['surat'] ?? null;
            try {
                $path = ROOT . app_config(PathEnum::PERMINTAAN_PEMBINAAN);
                if ($filename && is_file($path . '/' . $filename)) {
                    unlink($path . '/' . $filename);
                }
                PesanPermintaanModel::delete(['permintaan_id=' => $id]);
                DokumentasiPembinaanModel::update(['permintaan_id' => NULL], ['permintaan_id=' => $id]);
                PermintaanPembinaanModel::delete(['id=' => $id]);
                session()->addFlashSuccess('Hapus permintaan pembinaan berhasil.');
            } catch (Exception $e) {
                session()->addFlashError('Hapus permintaan pembinaan gagal. Error:' . $e->getMessage());
            }
        }

        return redirect_to(ResourceEnum::PERMINTAAN_PEMBINAAN_LIST);
    }
}
