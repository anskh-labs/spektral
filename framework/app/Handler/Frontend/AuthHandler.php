<?php

declare(strict_types=1);

namespace App\Handler\Frontend;

use App\Enums\ResourceEnum;
use App\Handler\ActionHandler;
use App\Model\Forms\LoginForm;
use App\Model\Forms\RegisterForm;
use App\Model\Forms\ResetForm;
use App\Model\Forms\ResetPasswordForm;
use App\Model\Db\UserModel;
use App\Model\Forms\UserForm;
use App\Helper\Service;
use App\Model\Db\TingkatInstansiModel;
use App\Model\Db\UserJoinTingkatInstansiModel;
use Faster\Helper\Token;
use Exception;
use Faster\Component\Enums\HttpMethodEnum;
use Faster\Http\Middleware\AuthMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use JKD\SSO\Client\Provider\Keycloak;

class AuthHandler extends ActionHandler
{
    /**
     * Handle route ResourceEnum::LOGIN or url '/auth/login'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        if (auth()->getIdentity()->isAuthenticated()) {
            if (is_internal(auth()->getIdentity()->getData())) {
                return redirect_to(ResourceEnum::DASHBOARD);
            } else {
                return redirect_to(ResourceEnum::HOME);
            }
        }

        $model = new LoginForm();
        if ($request->getMethod() === HttpMethodEnum::POST) {
            if ($model->fillAndValidateWith($request)) {
                if (is_internal($model->email)) {
                    $model->addError('Akun internal login menggunakan SSO.');
                    session()->addFlashError("Akun BPS login menggunakan SSO BPS.");
                } else {
                    $row = UserModel::row('*', ['email=' => $model->email]);
                    if ($row) {
                        if ($row['is_active'] == 0) {
                            $model->addError('Akun belum aktif, silahkan lakukan aktivasi sesuai dengan petunjuk yang dikirimkan via email.');
                        } elseif (password_verify($model->password, $row['password'])) {
                            session()->set(auth()->getProvider()->getUserIdAttribute(), strval($row['id']));
                            $roles = explode(',', $row['role']);
                            $userData = [
                                AuthMiddleware::USERID => $row['id'],
                                AuthMiddleware::ROLES => $roles,
                                AuthMiddleware::PERMISSIONS => auth()->getProvider()->getPermissions($roles),
                                AuthMiddleware::DATA => ['email' => $row['email'], 'nama' => $row['nama'], 'hp' => $row['nomor_wa']]
                            ];
                            $userHash = array_encode($userData);
                            session()->set(auth()->getProvider()->getUserHashAttribute(), $userHash);
                            session()->addFlashSuccess("Selamat datang '" . ucfirst($row['nama'] . "'"));

                            $query = $request->getQueryParams();
                            if($query['redirect_uri'] ?? null){
                                $redirect_uri = $query['redirect_uri'];
                                return redirect_uri($redirect_uri);
                            }else{
                                return redirect_to(ResourceEnum::HOME);
                            }
                        } else {
                            $model->addError('Email atau password tidak match.');
                        }
                    } else {
                        $model->addError('Email belum terdaftar.');
                    }
                }
            }
        }
        $params['page'] = 'LOGIN';
        $params['model'] = $model;
        $params['breadcrumbs'] = [];

        return view('login', $params, $response, 'frontend');
    }
    /**
     * handle route ResourceEnum::LOGOUT or url '/auth/logout'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function logout(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if (auth()->getIdentity()->isAuthenticated()) {
            session()->unset(auth()->getProvider()->getUserIdAttribute());
            session()->unset(auth()->getProvider()->getUserHashAttribute());
            if (is_internal(auth()->getIdentity()->getData())) {
                session()->unset('oauth2state');
                $provider = $this->getSSOProvider();
                $url_logout = $provider->getLogoutUrl();

                return redirect_uri($url_logout);
            } else {
                session()->addFlashSuccess('Logout berhasil');
                return redirect_uri(auth()->getProvider()->getLoginUri());
            }
        }
        return redirect_to(ResourceEnum::HOME);
    }
    /**
     * handle route ResourceEnum::DO_RESET_PASSWORD or url '/auth/reset-password/{token}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function doResetPassword(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $model = new ResetPasswordForm();
        $token = $request->getAttribute('token');
        $row = UserModel::row('*', ['reset_token=' => $token]);
        if ($row) {
            $params['token'] = $token;
            if ($request->getMethod() === HttpMethodEnum::POST) {
                if ($model->fillAndValidateWith($request)) {
                    try {
                        UserModel::update(
                            [
                                'password' => password_hash($model->password, PASSWORD_BCRYPT),
                                'is_active' => 1,
                                'reset_token' => NULL,
                                'update_at' => local_time()
                            ],
                            ['reset_token=' => $token]
                        );
                        session()->addFlashSuccess('Ubah password berhasil');
                    } catch (Exception $e) {
                        session()->addFlashSuccess('Ubah password gagal. Error:' . $e->getMessage());
                    }

                    return redirect_uri(auth()->getProvider()->getLoginUri());
                }
            }

            $params['page'] = 'RESET PASSWORD';
            $params['model'] = $model;

            return view('reset_password_form', $params, $response, 'frontend');
        } else {
            return redirect_uri(auth()->getProvider()->getLoginUri());
        }
    }
    /**
     * handle route ResourceEnum::RESET_PASSWORD or url '/auth/reset-password'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function resetPassword(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if (auth()->getIdentity()->isAuthenticated()) {
            return redirect_to(ResourceEnum::HOME);
        }

        $model = new ResetForm();
        if ($request->getMethod() === HttpMethodEnum::POST) {
            if ($model->fillAndValidateWith($request)) {
                if (is_internal($model->email)) {
                    $model->addError('Akun internal tidak dapat melakukan reset password.');
                    session()->addFlashError("Akun internal tidak dapat melakukan reset password.");
                } else {
                    $row = UserModel::row('*', ['email=' => $model->email]);
                    if ($row) {
                        $mail = Service::mailer(true);
                        try {
                            $mail->setFrom('ipds1400@bps.go.id', 'Noreply SPEKTRAL BPS Provinsi Riau');
                            $mail->addAddress($model->email);
                            $mail->addReplyTo('bps1400@bps.go.id', 'BPS Provinsi Riau');

                            $mail->isHTML(true);
                            $template = template_config('reset_password');
                            $mail->Subject = $template['subject'];
                            $message = str_replace('%client_name%', $row['nama'], $template['html_message']);
                            $token = Token::generateMD5Token();
                            $message = str_replace('%client_url%', base_url(route(ResourceEnum::DO_RESET_PASSWORD, $token)), $message);
                            $mail->Body    = $message;

                            $mail->send();

                            session()->addFlashSuccess('Reset password berhasil. Link reset berhasil dikirimkan ke email.');

                            UserModel::update(
                                [
                                    'reset_token' => $token,
                                    'update_at' => local_time()
                                ],
                                ['email=' => $model->email]
                            );
                        } catch (Exception $e) {
                            session()->addFlashError("Kirim email gagal. Error: {$mail->ErrorInfo}");
                        }
                        return redirect_uri(auth()->getProvider()->getLoginUri());
                    } else {
                        $model->addError('Alamat email tidak ditemukan. Silahkan perbaiki isian alamat email.', 'email');
                    }
                }
            }
        }

        $params['page'] = 'RESET PASSWORD';
        $params['model'] = $model;
        $params['breadcrumbs'] = [];

        return view('reset_password', $params, $response, 'frontend');
    }


    /**
     * handle route ResourceEnum::REGISTER or url '/auth/register'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function register(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if (auth()->getIdentity()->isAuthenticated()) {
            return redirect_to(ResourceEnum::HOME);
        }

        $model = new RegisterForm();
        if ($request->getMethod() === HttpMethodEnum::POST) {
            if ($model->fillAndValidateWith($request)) {
                if (is_internal($model->email)) {
                    $model->addError('Akun internal tidak dapat melakukan register.');
                    session()->addFlashError("Akun internal tidak dapat melakukan register.");
                } else {
                    $row = UserModel::row('*', ['email=' => $model->email]);
                    if ($row) {
                        $model->addError('Alamat email sudah digunakan, silahkan menggunakan alamat email lain.', 'email');
                    } else {
                        $mail = Service::mailer(true);
                        try {
                            $token = Token::generateMD5Token();

                            $mail->setFrom('ipds1400@bps.go.id', 'Noreply SPEKTRAL BPS Provinsi Riau');
                            $mail->addAddress($model->email);
                            $mail->addReplyTo('bps1400@bps.go.id', 'BPS Provinsi Riau');

                            $mail->isHTML(true);
                            $template = template_config('register');
                            $mail->Subject = $template['subject'];
                            $message = str_replace('%client_name%', $model->nama, $template['html_message']);
                            $message = str_replace('%client_url%', base_url(route('activation', $token)), $message);
                            $mail->Body    = $message;

                            $mail->send();

                            session()->addFlashSuccess('Daftar akun berhasil. Link aktivasi akun berhasil dikirimkan ke email.');

                            UserModel::create(
                                [
                                    'email' => $model->email,
                                    'password' => password_hash($model->password, PASSWORD_BCRYPT),
                                    'nama' => $model->nama,
                                    'nip' => $model->nip,
                                    'jabatan' => $model->jabatan,
                                    'instansi' => $model->instansi,
                                    'tingkat' => $model->tingkat,
                                    'nomor_wa' => $model->nomor_wa,
                                    'role' => 'user',
                                    'token' => $token,
                                    'is_active' => 0,
                                    'create_at' => local_time()
                                ]
                            );
                        } catch (Exception $e) {
                            session()->addFlashError("Kirim email gagal. Error: {$mail->ErrorInfo}");
                        }
                        return redirect_uri(auth()->getProvider()->getLoginUri());
                    }
                }
            }
        }

        $params['page'] = 'DAFTAR AKUN';
        $params['model'] = $model;
        $params['m_tingkat'] = TingkatInstansiModel::all();
        $params['breadcrumbs'] = [];

        return view('register', $params, $response, 'frontend');
    }
    /**
     * handle route ResourceEnum::LOGIN_SSO or url '/auth/login-sso'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function ssoLogin(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if (auth()->getIdentity()->isAuthenticated()) {
            return redirect_to(ResourceEnum::HOME);
        }

        $query = $request->getQueryParams();
        $provider = $this->getSSOProvider();
        if (!isset($query['code'])) {
            // Untuk mendapatkan authorization code
            $authUrl = $provider->getAuthorizationUrl();
            session()->set('oauth2state', $provider->getState());
            return redirect_uri($authUrl);
            // Mengecek state yang disimpan saat ini untuk memitigasi serangan CSRF
        } elseif (empty($query['state']) || ($query['state'] !== session()->get('oauth2state'))) {
            session()->unset('oauth2state');
            return redirect_to(ResourceEnum::LOGIN);
        } else {

            try {
                $token = $provider->getAccessToken('authorization_code', [
                    'code' => $query['code']
                ]);
            } catch (Exception $e) {
                throw new Exception('Gagal mendapatkan akses token : ' . $e->getMessage());
            }

            try {
                $user = $provider->getResourceOwner($token);
                if ($user) {
                    if ($user->getKodeProvinsi() === '14' && $user->getKodeKabupaten() === '00') {
                        $row = UserModel::row('*', ['email=' => $user->getEmail()]);
                        if (!$row) {
                            try {
                                UserModel::create(
                                    [
                                        'email' => $user->getEmail(),
                                        'nama' => $user->getName(),
                                        'nip' => $user->getNipBaru(),
                                        'jabatan' => $user->getJabatan(),
                                        'instansi' => 'BPS Provinsi Riau',
                                        'tingkat' => 'Provinsi',
                                        'nomor_wa' => '12345678910',
                                        'role' => 'user,viewer',
                                        'is_active' => 1,
                                        'create_at' => local_time()
                                    ]
                                );
                                $row = UserModel::row('*', ['email=' => $user->getEmail()]);
                            } catch (Exception $e) {
                                session()->addFlashError('Gagal menambahkan akun internal secara otomatis. Error:' . $e->getMessage());
                            }
                        }
                        if ($row['is_active'] == 0) {
                            session()->addFlashWarning('Status pengguna tidak aktif. Silahkan menghubungi admin untuk aktivasi.');
                            return redirect_uri(auth()->getProvider()->getLoginUri());
                        }
                        session()->set(auth()->getProvider()->getUserIdAttribute(), strval($row['id']));
                        $roles = explode(',', $row['role']);
                        $userData = [
                            AuthMiddleware::USERID => $row['id'],
                            AuthMiddleware::ROLES => $roles,
                            AuthMiddleware::PERMISSIONS => auth()->getProvider()->getPermissions($roles),
                            AuthMiddleware::DATA => ['email' => $row['email'], 'nama' => $row['nama'], 'hp' => $row['nomor_wa']]
                        ];
                        $userHash = array_encode($userData);
                        session()->set(auth()->getProvider()->getUserHashAttribute(), $userHash);
                        session()->addFlashSuccess("Selamat datang '" . ucfirst($row['nama'] . "'"));

                        return redirect_to(ResourceEnum::DASHBOARD);
                    } else {
                        session()->unset('oauth2state');
                        $provider = $this->getSSOProvider();
                        $logout_url = $provider->getLogoutUrl();
                        $params['page'] = 'LOGIN';
                        $params['breadcrumbs'] = [];
                        $params['logout_url'] = $logout_url;
                        return view('auth_forbidden', $params, $response, 'frontend');
                    }
                }
                // echo "Nama : ".$user->getName();
                // echo "E-Mail : ". $user->getEmail();
                // echo "Username : ". $user->getUsername();
                // echo "NIP : ". $user->getNip();
                // echo "NIP Baru : ". $user->getNipBaru();
                // echo "Kode Organisasi : ". $user->getKodeOrganisasi();
                // echo "Kode Provinsi : ". $user->getKodeProvinsi();
                // echo "Kode Kabupaten : ". $user->getKodeKabupaten();
                // echo "Alamat Kantor : ". $user->getAlamatKantor();
                // echo "Provinsi : ". $user->getProvinsi();
                // echo "Kabupaten : ". $user->getKabupaten();
                // echo "Golongan : ". $user->getGolongan();
                // echo "Jabatan : ". $user->getJabatan();
                // echo "Foto : ". $user->getUrlFoto();
                // echo "Eselon : ". $user->getEselon();
                // Gunakan token ini untuk berinteraksi dengan API di sisi pengguna
                //echo $token->getToken();        
            } catch (Exception $e) {
                throw new Exception('Gagal Mendapatkan Data Pengguna: ' . $e->getMessage());
            }
            return redirect_uri(auth()->getProvider()->getLoginUri());
        }
    }
    /**
     * getSSOProvider
     *
     * @return Keycloak
     */
    private function getSSOProvider(): Keycloak
    {
        $redirectUri = base_url(route(ResourceEnum::LOGIN_SSO));
        
        return new Keycloak([
            'authServerUrl'         => 'https://sso.bps.go.id',
            'realm'                 => 'pegawai-bps',
            'clientId'              => '11400-spektral-p0s',
            'clientSecret'          => 'f03f924e-9f3e-4ab8-b3a3-f8ac906f2e80',
            'redirectUri'           => $redirectUri
        ]);
    }
    /**
     * handle route ResourceEnum::ACTIVATION or url '/auth/user-activation/{$token}'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function activation(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $token = $request->getAttribute('token');
        $row = UserModel::row('*', ['token=' => $token]);
        if ($row) {
            try {
                UserModel::update(['is_active' => 1, 'token' => NULL, 'update_at' => local_time()], ['token=' => $token]);
                session()->addFlashSuccess('Activasi akun berhasil.');
            } catch (Exception $e) {
                session()->addFlashError('Activasi akun gagal. Error:' . $e->getMessage());
            }
        } else {
            session()->addFlashError('Activasi akun gagal.');
        }

        return redirect_uri(auth()->getProvider()->getLoginUri());
    }
    /**
     * Handle route ResourceEnum::USER_INFO or path '/auth/info'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function infoUser(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if (auth()->isGuest()) {
            return redirect_to(ResourceEnum::HOME);
        }

        $params['breadcrumbs'] = [];
        $params['page'] = 'INFORMASI PENGGUNA';
        $params['model'] = new UserForm();
        $params['row'] = UserJoinTingkatInstansiModel::row('*', ['a.id=' => auth()->getIdentity()->getId()]);

        return view('user_info', $params, $response, 'frontend');
    }
    /**
     * Handle route ResourceEnum::USER_UPDATE or path '/auth/update'
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function updateUser(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if (auth()->isGuest()) {
            return redirect_to(ResourceEnum::HOME);
        }

        $row = UserModel::row('nama,email,nip,jabatan,tingkat,nomor_wa,instansi', ['id=' => auth()->getIdentity()->getId()]);
        $model = new UserForm(true);
        $model->fill($row);
        if ($request->getMethod() === HttpMethodEnum::POST) {
            if ($model->fillAndValidateWith($request)) {
                $data = [
                    'nama' => $model->nama,
                    'nip' => $model->nip,
                    'nomor_wa' => $model->nomor_wa,
                    'instansi' => $model->instansi,
                    'tingkat' => $model->tingkat,
                    'jabatan' => $model->jabatan,
                    'update_at' => local_time(),
                    'update_by' => auth()->getIdentity()->getId()
                ];
                if ($model->password) {
                    $data['password'] = password_hash($model->password, PASSWORD_BCRYPT);
                }
                try {
                    UserModel::update($data, ['id=' => auth()->getIdentity()->getId()]);
                    session()->addFlashSuccess('Ubah data berhasil disimpan.');
                } catch (Exception $e) {
                    session()->addFlashError('Ubah data gagal. Error:' . $e->getMessage());
                }

                return redirect_to(ResourceEnum::USER_INFO);
            }
        }

        $params['breadcrumbs'] = [];
        $params['page'] = 'UBAH DATA PENGGUNA';
        $params['row'] = $row;
        $params['model'] = $model;
        $params['m_tingkat'] = TingkatInstansiModel::all();

        return view('user_update', $params, $response, 'frontend');
    }
}
