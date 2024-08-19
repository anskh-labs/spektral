<?php

declare(strict_types=1);

use App\Enums\ResourceEnum;
use App\Enums\StatusPermintaanEnum;
use Faster\Component\Enums\FlashMessageEnum;
use Faster\Http\Auth\UserPrincipalInterface;
use Faster\Http\Session\FlashMessage;
use Faster\Helper\View;
use Faster\Model\DbPaginationInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;

if (!function_exists('view')) {
    /**
     * view
     *
     * @param  mixed $view
     * @param  mixed $params
     * @param  mixed $response
     * @param  mixed $template
     * @return ResponseInterface
     */
    function view(string $content, array $params, ResponseInterface $response, string $template = 'template'): ResponseInterface
    {
        $renderer = View::renderer();
        $renderer->setParam('content', $content);
        $response->getBody()->write($renderer->render('template/' . $template, $params));

        return $response;
    }
}
if (!function_exists('render')) {
    /**
     * render
     *
     * @param  mixed $view
     * @param  mixed $params
     * @param  mixed $response
     * @return ResponseInterface
     */
    function render(string $view, array $params, ResponseInterface $response): ResponseInterface
    {
        $renderer = View::renderer();
        $response->getBody()->write($renderer->render($view, $params));

        return $response;
    }
}
if (!function_exists('render_json')) {
    /**
     * render_json
     *
     * @param  mixed $data
     * @return ResponseInterface
     */
    function render_json($data): ResponseInterface
    {
        $response = new JsonResponse($data);

        return $response;
    }
}
if (!function_exists('sweet_alert')) {

    /**
     * sweet_alert
     *
     * @param  mixed $flash
     * @return string
     */
    function sweet_alert(FlashMessage $flash): string
    {
        $type =  $flash->getType() === FlashMessageEnum::ERROR ? 'error' : $flash->getType();

        return sprintf('Swal.fire({title: "%s",text: "%s",icon: "%s"});', strtoupper($type), $flash->firstMessage(), $type);
    }
}
if (!function_exists('rfc822_date')) {
    /**
     * get RFC 822 Date
     *
     * @return string
     */
    function rfc822_date(): string
    {
        $timezone = date('Z');
        $operator = ($timezone[0] === '-') ? '-' : '+';
        $timezone = abs(intval($timezone));
        $timezone = floor($timezone / 3600) * 100 + ($timezone % 3600) / 60;

        return sprintf('%s %s%04d', date('D, j M Y H:i:s'), $operator, $timezone);
    }
}
if (!function_exists('ticket_readonly')) {
    /**
     * ticket_readonly
     *
     * @param  mixed $id
     * @return bool
     */
    function ticket_readonly($id): bool
    {
        return $id == StatusPermintaanEnum::APPROVED || $id == StatusPermintaanEnum::CLOSED;
    }
}
if (!function_exists('is_internal')) {
    /**
     * is_internal
     *
     * @param  array|string $userData
     * @return bool
     */
    function is_internal(array|string $userData): bool
    {
        if (is_array($userData)) {
            $email = $userData['email'];
        } else {
            $email = $userData;
        }
        return str_ends_with(rtrim($email), '@bps.go.id') ? true : false;
    }
}
if (!function_exists('app_config')) {
    /**
     * app_config
     *
     * @param  string $offset
     * @param  mixed $defaultValue
     * @return mixed
     */
    function app_config(string $offset, mixed $defaultValue = null): mixed
    {
        return config('app.' . $offset, $defaultValue);
    }
}
if (!function_exists('db_config')) {
    /**
     * db_config
     *
     * @param  string $offset
     * @param  mixed $defaultValue
     * @return mixed
     */
    function db_config(string $offset, mixed $defaultValue = null): mixed
    {
        return config('database.' . $offset, $defaultValue);
    }
}
if (!function_exists('template_config')) {
    /**
     * template_config
     *
     * @param  string $offset
     * @param  mixed $defaultValue
     * @return mixed
     */
    function template_config(string $offset, mixed $defaultValue = null): mixed
    {
        return config('template.' . $offset, $defaultValue);
    }
}
if (!function_exists('view_config')) {
    /**
     * view_config
     *
     * @param  string $offset
     * @param  mixed $defaultValue
     * @return mixed
     */
    function view_config(string $offset, mixed $defaultValue = null): mixed
    {
        return config('view.' . $offset, $defaultValue);
    }
}
if (!function_exists('security_config')) {
    /**
     * security_config
     *
     * @param  string $offset
     * @param  mixed $defaultValue
     * @return mixed
     */
    function security_config(string $offset, mixed $defaultValue = null): mixed
    {
        return config('security.' . $offset, $defaultValue);
    }
}
if (!function_exists('smtp_config')) {
    /**
     * smtp_config
     *
     * @param  string $offset
     * @param  mixed $defaultValue
     * @return mixed
     */
    function smtp_config(string $offset, mixed $defaultValue = null): mixed
    {
        return config('smtp.' . $offset, $defaultValue);
    }
}
if (!function_exists('error_config')) {
    /**
     * error_config
     *
     * @param  string $offset
     * @param  mixed $defaultValue
     * @return mixed
     */
    function error_config(string $offset, mixed $defaultValue = null): mixed
    {
        return config('errora.' . $offset, $defaultValue);
    }
}
if (!function_exists('array_with_key')) {

    /**
     * array_with_key
     *
     * @param  array $data
     * @param  string $key
     * @return array
     */
    function array_with_key(array $data, string $key): array
    {
        return array_map(fn ($attr) => $attr[$key], $data);
    }
}
if (!function_exists('is_menu_admin_dashboard')) {
    /**
     * is_menu_admin_dashboard
     *
     * @return bool
     */
    function is_menu_admin_dashboard(): bool
    {
        return is_route(ResourceEnum::DASHBOARD);
    }
}
if (!function_exists('is_menu_admin_modul')) {
    /**
     * is_menu_admin_modul
     *
     * @return bool
     */
    function is_menu_admin_modul(): bool
    {
        return is_menu_admin_modul_gsbpm() ||
            is_menu_admin_modul_pembinaan() ||
            is_menu_admin_modul_literasi();
    }
}
if (!function_exists('is_menu_admin_modul_gsbpm')) {
    /**
     * is_menu_admin_modul_gsbpm
     *
     * @return bool
     */
    function is_menu_admin_modul_gsbpm(): bool
    {
        return is_route([
            ResourceEnum::ADMIN_MODUL_GSBPM_LIST,
            ResourceEnum::ADMIN_MODUL_GSBPM_EDIT
        ]);
    }
}
if (!function_exists('is_menu_admin_modul_pembinaan')) {
    /**
     * is_menu_admin_modul_pembinaan
     *
     * @return bool
     */
    function is_menu_admin_modul_pembinaan(): bool
    {
        return is_route([
            ResourceEnum::ADMIN_MODUL_PEMBINAAN_LIST,
            ResourceEnum::ADMIN_MODUL_PEMBINAAN_ENTRY,
            ResourceEnum::ADMIN_MODUL_PEMBINAAN_EDIT,
            ResourceEnum::ADMIN_MODUL_PEMBINAAN_DELETE
        ]);
    }
}
if (!function_exists('is_menu_admin_modul_literasi')) {
    /**
     * is_menu_admin_modul_literasi
     *
     * @return bool
     */
    function is_menu_admin_modul_literasi(): bool
    {
        return is_route([
            ResourceEnum::ADMIN_MODUL_LITERASI_LIST,
            ResourceEnum::ADMIN_MODUL_LITERASI_ENTRY,
            ResourceEnum::ADMIN_MODUL_LITERASI_EDIT,
            ResourceEnum::ADMIN_MODUL_LITERASI_DELETE
        ]);
    }
}
if (!function_exists('is_menu_admin_permintaan_pembinaan')) {
    /**
     * is_menu_admin_permintaan_pembinaan
     *
     * @return bool
     */
    function is_menu_admin_permintaan_pembinaan(): bool
    {
        return is_route([
            ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_LIST,
            ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_VIEW
        ]);
    }
}
if (!function_exists('is_menu_home')) {
    /**
     * is_menu_home
     *
     * @return bool
     */
    function is_menu_home(): bool
    {
        return is_route(ResourceEnum::HOME);
    }
}
if (!function_exists('is_menu_modul')) {
    /**
     * is_menu_modul
     *
     * @return bool
     */
    function is_menu_modul(): bool
    {
        return is_route([
            ResourceEnum::MODUL_PEMBINAAN_LIST,
            ResourceEnum::GSBPM,
            ResourceEnum::MODUL_LITERASI_LIST
        ]);
    }
}
if (!function_exists('is_menu_layanan_instansi')) {
    /**
     * is_menu_layanan_instansi
     *
     * @return bool
     */
    function is_menu_layanan_instansi(): bool
    {
        return is_route([
            ResourceEnum::ROMANTIK,
            ResourceEnum::METADATA
        ]) || is_menu_permintaan_pembinaan();
    }
}
if (!function_exists('is_menu_permintaan_pembinaan')) {
    /**
     * is_menu_permintaan_pembinaan
     *
     * @return bool
     */
    function is_menu_permintaan_pembinaan(): bool
    {
        return is_route([
            ResourceEnum::PERMINTAAN_PEMBINAAN_LIST,
            ResourceEnum::PERMINTAAN_PEMBINAAN_ENTRY,
            ResourceEnum::PERMINTAAN_PEMBINAAN_EDIT,
            ResourceEnum::PERMINTAAN_PEMBINAAN_VIEW
        ]);
    }
}
if (!function_exists('is_menu_dokumentasi')) {
    /**
     * is_menu_dokumentasi
     *
     * @return bool
     */
    function is_menu_dokumentasi(): bool
    {
        return is_route([
            ResourceEnum::TESTIMONI
        ]) || is_menu_dokumentasi_pembinaan();
    }
}
if (!function_exists('is_menu_dokumentasi_pembinaan')) {
    /**
     * is_menu_dokumentasi_pembinaan
     *
     * @return bool
     */
    function is_menu_dokumentasi_pembinaan(): bool
    {
        return is_route([
            ResourceEnum::DOKUMENTASI_PEMBINAAN_LIST,
            ResourceEnum::DOKUMENTASI_PEMBINAAN_VIEW
        ]);
    }
}
if (!function_exists('is_menu_admin_dokumentasi')) {
    /**
     * is_menu_admin_dokumentasi
     *
     * @return bool
     */
    function is_menu_admin_dokumentasi(): bool
    {
        return is_menu_admin_dokumentasi_pembinaan() || is_menu_admin_dokumentasi_testimoni();
    }
}
if (!function_exists('is_menu_admin_dokumentasi_pembinaan')) {
    /**
     * is_menu_admin_dokumentasi_pembinaan
     *
     * @return bool
     */
    function is_menu_admin_dokumentasi_pembinaan(): bool
    {
        return is_route([
            ResourceEnum::ADMIN_DOKUMENTASI_LIST,
            ResourceEnum::ADMIN_DOKUMENTASI_ENTRY,
            ResourceEnum::ADMIN_DOKUMENTASI_VIEW,
            ResourceEnum::ADMIN_DOKUMENTASI_EDIT
        ]);
    }
}
if (!function_exists('is_menu_admin_dokumentasi_testimoni')) {
    /**
     * is_menu_admin_dokumentasi_testimoni
     *
     * @return bool
     */
    function is_menu_admin_dokumentasi_testimoni(): bool
    {
        return is_route([
            ResourceEnum::ADMIN_TESTIMONI_LIST,
            ResourceEnum::ADMIN_TESTIMONI_EDIT
        ]);
    }
}
if (!function_exists('is_menu_admin_user')) {
    /**
     * is_menu_admin_user
     *
     * @return bool
     */
    function is_menu_admin_user(): bool
    {
        return is_route([
            ResourceEnum::ADMIN_USER_LIST,
            ResourceEnum::ADMIN_USER_VIEW,
            ResourceEnum::ADMIN_USER_EDIT,
            ResourceEnum::ADMIN_ROLE_LIST
        ]);
    }
}
if (!function_exists('is_menu_admin_master')) {
    /**
     * is_menu_admin_master
     *
     * @return bool
     */
    function is_menu_admin_master(): bool
    {
        return is_menu_admin_user() || 
            is_menu_admin_kategori_modul_pembinaan() ||
            is_menu_admin_kategori_modul_literasi() ||
            is_menu_admin_model_pembinaan() ||
            is_menu_admin_status_permintaan() ||
            is_menu_admin_tingkat_instansi();
    }
}
if (!function_exists('is_menu_admin_kategori_modul_pembinaan')) {
    /**
     * is_menu_admin_kategori_modul_pembinaan
     *
     * @return bool
     */
    function is_menu_admin_kategori_modul_pembinaan(): bool
    {
        return is_route([
            ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_LIST,
            ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_EDIT,
            ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_ENTRY
        ]);
    }
}
if (!function_exists('is_menu_admin_kategori_modul_literasi')) {
    /**
     * is_menu_admin_kategori_modul_literasi
     *
     * @return bool
     */
    function is_menu_admin_kategori_modul_literasi(): bool
    {
        return is_route([
            ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_LIST,
            ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_ENTRY,
            ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_EDIT
        ]);
    }
}
if (!function_exists('is_menu_admin_model_pembinaan')) {
    /**
     * is_menu_admin_model_pembinaan
     *
     * @return bool
     */
    function is_menu_admin_model_pembinaan(): bool
    {
        return is_route([
            ResourceEnum::ADMIN_MODEL_PEMBINAAN_LIST,
            ResourceEnum::ADMIN_MODEL_PEMBINAAN_EDIT,
            ResourceEnum::ADMIN_MODEL_PEMBINAAN_ENTRY
        ]);
    }
}
if (!function_exists('is_menu_admin_status_permintaan')) {
    /**
     * is_menu_admin_status_permintaan
     *
     * @return bool
     */
    function is_menu_admin_status_permintaan(): bool
    {
        return is_route([
            ResourceEnum::ADMIN_STATUS_PERMINTAAN_LIST,
            ResourceEnum::ADMIN_STATUS_PERMINTAAN_EDIT,
            ResourceEnum::ADMIN_STATUS_PERMINTAAN_ENTRY
        ]);
    }
}
if (!function_exists('is_menu_admin_tingkat_instansi')) {
    /**
     * is_menu_admin_tingkat_instansi
     *
     * @return bool
     */
    function is_menu_admin_tingkat_instansi(): bool
    {
        return is_route([
            ResourceEnum::ADMIN_TINGKAT_INSTANSI_LIST,
            ResourceEnum::ADMIN_TINGKAT_INSTANSI_EDIT,
            ResourceEnum::ADMIN_TINGKAT_INSTANSI_ENTRY
        ]);
    }
}
if (!function_exists('is_menu_profil')) {
    /**
     * is_menu_profil
     *
     * @return bool
     */
    function is_menu_profil(): bool
    {
        return is_route([
            ResourceEnum::USER_INFO,
            ResourceEnum::USER_UPDATE
        ]);
    }
}
if (!function_exists('is_menu_admin_profil')) {
    /**
     * is_menu_admin_profil
     *
     * @return bool
     */
    function is_menu_admin_profil(): bool
    {
        return is_route([
            ResourceEnum::ADMIN_USER_INFO
        ]);
    }
}
if (!function_exists('view_rating')) {
    /**
     * view_rating
     *
     * @param  mixed $value
     * @param  mixed $min
     * @param  mixed $max
     * @return string
     */
    function view_rating(int $value, int $min = 1, int $max = 5): string
    {
        $html = '';
        for ($i = $min; $i <= $max; $i++) {
            if ($i <= $value) {
                $html .= '<span class="text-warning"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path transform="rotate(0,8,8) translate(2.38418749631819E-06,0) scale(0.500000357628124,0.500000357628124)" d="M16.001007,0L20.944,10.533997 32,12.223022 23.998993,20.421997 25.889008,32 16.001007,26.533997 6.1109924,32 8,20.421997 0,12.223022 11.057007,10.533997z" />
            </svg></span>';
            }else{
                $html .= '<span class="text-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path transform="rotate(0,8,8) translate(2.38418749631819E-06,0) scale(0.500000357628124,0.500000357628124)" d="M16.001007,0L20.944,10.533997 32,12.223022 23.998993,20.421997 25.889008,32 16.001007,26.533997 6.1109924,32 8,20.421997 0,12.223022 11.057007,10.533997z" />
                                </svg></span>';
            }
        }

        return $html;
    }
}
if (!function_exists('record_info')) {
    /**
     * record_info
     *
     * @param  DbPaginationInterface $pagination
     * @return string
     */
    function record_info(DbPaginationInterface $pagination): string
    {
        $total = $pagination->recordCount();
        $start =  $total > 0 ? $pagination->offset() + 1 : 0;
        $end = $total > 0 ? $start + $pagination->currentRecordCount() - 1 : 0;
        
        return "Menampilkan $start sampai $end dari $total";
    }
}
