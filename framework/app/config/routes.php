<?php

declare(strict_types=1);

use App\Enums\ResourceEnum;
use App\Handler\AdminHandler;
use App\Handler\Backend\AdminModulGsbpmHandler;
use App\Handler\Backend\AdminModulPembinaanHandler;
use App\Handler\Backend\AdminModulLiterasiHandler;
use App\Handler\Backend\AdminPermintaanPembinaanHandler;
use App\Handler\Backend\AdminRoleHandler;
use App\Handler\Backend\AdminUserHandler;
use App\Handler\Backend\DashboardHandler;
use App\Handler\Backend\KategoriModulLiterasiHandler;
use App\Handler\Backend\KategoriModulPembinaanHandler;
use App\Handler\Backend\ModelPembinaanHandler;
use App\Handler\Backend\StatusPermintaanHandler;
use App\Handler\Backend\TingkatInstansiHandler;
use App\Handler\Backend\AdminDokumentasiPembinaanHandler;
use App\Handler\Backend\AdminTestimoniHandler;
use App\Handler\Frontend\AuthHandler;
use App\Handler\Frontend\DokumentasiPembinaanHandler;
use App\Handler\Frontend\PermintaanPembinaanHandler;
use App\Handler\Frontend\GsbpmHandler;
use App\Handler\Frontend\HomeHandler;
use App\Handler\Frontend\MetadataHandler;
use App\Handler\Frontend\RomantikHandler;
use App\Handler\Frontend\ModulLiterasiHandler;
use App\Handler\Frontend\ModulPembinaanHandler;
use App\Handler\Frontend\TestimoniHandler;

return [
    /* -------------------------------- */
    /* Frontend                         */
    /* -------------------------------- */
    ResourceEnum::MAINTENANCE => [
        'GET',
        '/maintenance',
        [HomeHandler::class, 'maintenance']
    ],
    ResourceEnum::HOME => [
        'GET',
        '/',
        HomeHandler::class
    ],
    ResourceEnum::METADATA => [
        'GET',
        '/metadata',
        MetadataHandler::class
    ],
    ResourceEnum::ROMANTIK => [
        'GET',
        '/romantik',
        RomantikHandler::class
    ],
    ResourceEnum::GSBPM => [
        'GET',
        '/modul-gsbpm[/{step}]',
        GsbpmHandler::class
    ],

    ResourceEnum::MODUL_PEMBINAAN_LIST => [
        'GET',
        '/modul-pembinaan[/{cat}]',
        ModulPembinaanHandler::class
    ],
    ResourceEnum::MODUL_LITERASI_LIST => [
        'GET',
        '/modul-literasi[/{cat}]',
        ModulLiterasiHandler::class
    ],

    ResourceEnum::PERMINTAAN_PEMBINAAN_LIST => [
        'GET',
        '/permintaan-pembinaan',
        PermintaanPembinaanHandler::class
    ],
    ResourceEnum::PERMINTAAN_PEMBINAAN_ENTRY => [
        ['GET', 'POST'],
        '/permintaan-pembinaan/entry',
        [PermintaanPembinaanHandler::class, 'entryPermintaanPembinaan']
    ],
    ResourceEnum::PERMINTAAN_PEMBINAAN_VIEW => [
        ['GET', 'POST'],
        '/permintaan-pembinaan/view/{id:\d+}',
        [PermintaanPembinaanHandler::class, 'viewPermintaanPembinaan']
    ],
    ResourceEnum::PERMINTAAN_PEMBINAAN_EDIT => [
        ['GET', 'POST'],
        '/permintaan-pembinaan/edit/{id:\d+}',
        [PermintaanPembinaanHandler::class, 'editPermintaanPembinaan']
    ],
    ResourceEnum::PERMINTAAN_PEMBINAAN_DELETE => [
        'GET',
        '/permintaan-pembinaan/delete/{id:\d+}',
        [PermintaanPembinaanHandler::class, 'deletePermintaanPembinaan']
    ],

    ResourceEnum::DOKUMENTASI_PEMBINAAN_LIST => [
        'GET',
        '/dokumentasi-pembinaan',
        DokumentasiPembinaanHandler::class
    ],
    ResourceEnum::DOKUMENTASI_PEMBINAAN_VIEW => [
        'GET',
        '/dokumentasi-pembinaan/view/{id:\d+}',
        [DokumentasiPembinaanHandler::class, 'viewDokumentasiPembinaan']
    ],

    ResourceEnum::TESTIMONI => [
        ['GET', 'POST'],
        '/testimoni',
        TestimoniHandler::class
    ],

    ResourceEnum::LOGIN => [
        ['GET', 'POST'],
        '/auth/login',
        AuthHandler::class
    ],
    ResourceEnum::LOGOUT => [
        'GET', 
        '/auth/logout', 
        [AuthHandler::class, 'logout']
    ],
    ResourceEnum::USER_INFO => [
        'GET', 
        '/account/info', 
        [AuthHandler::class, 'infoUser']
    ],
    ResourceEnum::USER_UPDATE => [
        ['GET', 'POST'], 
        '/account/update', 
        [AuthHandler::class, 'updateUser']
    ],
    ResourceEnum::LOGIN_SSO => [
        'GET', 
        '/auth/login-sso', 
        [AuthHandler::class, 'ssoLogin']
    ],
    ResourceEnum::RESET_PASSWORD => [
        ['GET', 'POST'], 
        '/auth/reset-password', 
        [AuthHandler::class, 'resetPassword']
    ],
    ResourceEnum::DO_RESET_PASSWORD => [
        ['GET', 'POST'], 
        '/auth/reset-password/{token}', 
        [AuthHandler::class, 'doResetPassword']
    ],
    ResourceEnum::REGISTER => [
        ['GET', 'POST'], 
        '/auth/register', 
        [AuthHandler::class, 'register']
    ],
    ResourceEnum::ACTIVATION => [
        'GET', 
        '/auth/user-activation/{token}', 
        [AuthHandler::class, 'activation']
    ],

    /* -------------------------------- */
    /* Backend                          */
    /* -------------------------------- */
    ResourceEnum::DASHBOARD => [
        'GET', 
        '/internal', 
        DashboardHandler::class
    ],

    ResourceEnum::ADMIN_USER_LIST => [
        'GET', 
        '/internal/user', 
        AdminUserHandler::class
    ],
    ResourceEnum::ADMIN_USER_VIEW => [
        'GET', 
        '/internal/user/view/{id:\d+}', 
        [AdminUserHandler::class, 'viewUser']
    ],
    ResourceEnum::ADMIN_USER_DELETE => [
        'GET', 
        '/internal/user/delete/{id:\d+}', 
        [AdminUserHandler::class, 'deleteUser']
    ],
    ResourceEnum::ADMIN_USER_EDIT => [
        ['GET', 'POST'], 
        '/internal/user/edit/{id:\d+}', 
        [AdminUserHandler::class, 'editUser']
    ],
    ResourceEnum::ADMIN_USER_INFO => [
        'GET', 
        '/internal/account/info', 
        [AdminUserHandler::class, 'infoUser']
    ],

    ResourceEnum::ADMIN_ROLE_LIST => [
        'GET', 
        '/internal/user-role', 
        AdminRoleHandler::class
    ],

    ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_LIST => [
        'GET', 
        '/internal/permintaan-pembinaan', 
        AdminPermintaanPembinaanHandler::class
    ],
    ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_VIEW => [
        ['GET', 'POST'], 
        '/internal/permintaan-pembinaan/view/{id:\d+}', 
        [AdminPermintaanPembinaanHandler::class, 'viewPermintaanPembinaan']
    ],
    ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_DELETE => [
        'GET', 
        '/internal/permintaan-pembinaan/delete/{id:\d+}', 
        [AdminPermintaanPembinaanHandler::class, 'deletePermintaanPembinaan']
    ],

    ResourceEnum::ADMIN_MODUL_GSBPM_LIST => [
        'GET', 
        '/internal/modul-gsbpm[/{step:\d+}]', 
        AdminModulGsbpmHandler::class
    ],
    ResourceEnum::ADMIN_MODUL_GSBPM_EDIT => [
        ['GET', 'POST'], 
        '/internal/modul-gsbpm/edit/{id:\d+}', 
        [AdminModulGsbpmHandler::class, 'edit']
    ],

    ResourceEnum::ADMIN_MODUL_PEMBINAAN_LIST => [
        'GET', 
        '/internal/modul-pembinaan[/{cat:\d+}]', 
        AdminModulPembinaanHandler::class
    ],
    ResourceEnum::ADMIN_MODUL_PEMBINAAN_EDIT => [
        ['GET', 'POST'], 
        '/internal/modul-pembinaan/edit/{id:\d+}', 
        [AdminModulPembinaanHandler::class, 'edit']
    ],
    ResourceEnum::ADMIN_MODUL_PEMBINAAN_DELETE => [
        'GET', 
        '/internal/modul-pembinaan/delete/{id:\d+}', 
        [AdminModulPembinaanHandler::class, 'delete']
    ],
    ResourceEnum::ADMIN_MODUL_PEMBINAAN_ENTRY => [
        ['GET', 'POST'], 
        '/internal/modul-pembinaan/entri[/{cat:\d+}]', 
        [AdminModulPembinaanHandler::class, 'entry']
    ],

    ResourceEnum::ADMIN_MODUL_LITERASI_LIST => [
        'GET', 
        '/internal/modul-literasi[/{cat:\d+}]', 
        AdminModulLiterasiHandler::class
    ],
    ResourceEnum::ADMIN_MODUL_LITERASI_EDIT => [
        ['GET', 'POST'], 
        '/internal/modul-literasi/edit/{id:\d+}', 
        [AdminModulLiterasiHandler::class, 'edit']
    ],
    ResourceEnum::ADMIN_MODUL_LITERASI_DELETE => [
        'GET', 
        '/internal/modul-literasi/delete/{id:\d+}', 
        [AdminModulLiterasiHandler::class, 'delete']
    ],
    ResourceEnum::ADMIN_MODUL_LITERASI_ENTRY => [
        ['GET', 'POST'], 
        '/internal/modul-literasi/entri[/{cat:\d+}]', 
        [AdminModulLiterasiHandler::class, 'entry']
    ],

    ResourceEnum::ADMIN_DOKUMENTASI_LIST => [
        'GET', 
        '/internal/dokumentasi-pembinaan', 
        AdminDokumentasiPembinaanHandler::class
    ],
    ResourceEnum::ADMIN_DOKUMENTASI_VIEW => [
        ['GET', 'POST'], 
        '/internal/dokumentasi-pembinaan/view/{id:\d+}', 
        [AdminDokumentasiPembinaanHandler::class, 'view']
    ],
    ResourceEnum::ADMIN_DOKUMENTASI_ENTRY => [
        ['GET', 'POST'], 
        '/internal/dokumentasi-pembinaan/entri', 
        [AdminDokumentasiPembinaanHandler::class, 'entry']
    ],
    ResourceEnum::ADMIN_DOKUMENTASI_EDIT => [
        ['GET', 'POST'], 
        '/internal/dokumentasi-pembinaan/edit/{id:\d+}', 
        [AdminDokumentasiPembinaanHandler::class, 'edit']
    ],
    ResourceEnum::ADMIN_DOKUMENTASI_DELETE => [
        ['GET', 'POST'], 
        '/internal/dokumentasi-pembinaan/delete/{id:\d+}', 
        [AdminDokumentasiPembinaanHandler::class, 'delete']
    ],

    ResourceEnum::ADMIN_TESTIMONI_LIST => [
        'GET', 
        '/internal/testimoni', 
        AdminTestimoniHandler::class
    ],
    ResourceEnum::ADMIN_TESTIMONI_EDIT => [
        ['GET', 'POST'], 
        '/internal/testimoni/edit/{id:\d+}', 
        [AdminTestimoniHandler::class, 'edit']
    ],
    ResourceEnum::ADMIN_TESTIMONI_DELETE => [
        ['GET', 'POST'], 
        '/internal/testimoni/delete/{id:\d+}', 
        [AdminTestimoniHandler::class, 'delete']
    ],

    ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_LIST => [
        'GET', 
        '/internal/kategori-modul-pembinaan', 
        KategoriModulPembinaanHandler::class
    ],
    ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_ENTRY => [
        ['GET', 'POST'], 
        '/internal/kategori-modul-pembinaan/entri', 
        [KategoriModulPembinaanHandler::class, 'entry']
    ],
    ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_EDIT => [
        ['GET', 'POST'],
        '/internal/kategori-modul-pembinaan/edit/{id:\d+}', 
        [KategoriModulPembinaanHandler::class, 'edit']
    ],
    ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_DELETE => [
        ['GET', 'POST'], 
        '/internal/kategori-modul-pembinaan/delete/{id:\d+}', 
        [KategoriModulPembinaanHandler::class, 'delete']
    ],

    ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_LIST => [
        'GET', 
        '/internal/kategori-modul-literasi', 
        KategoriModulLiterasiHandler::class
    ],
    ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_ENTRY => [
        ['GET', 'POST'], 
        '/internal/kategori-modul-literasi/entri', 
        [KategoriModulLiterasiHandler::class, 'entry']
    ],
    ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_EDIT => [
        ['GET', 'POST'], 
        '/internal/kategori-modul-literasi/edit/{id:\d+}', 
        [KategoriModulLiterasiHandler::class, 'edit']
    ],
    ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_DELETE => [
        ['GET', 'POST'], 
        '/internal/kategori-modul-literasi/delete/{id:\d+}', 
        [KategoriModulLiterasiHandler::class, 'delete']
    ],

    ResourceEnum::ADMIN_MODEL_PEMBINAAN_LIST => [
        'GET', 
        '/internal/model-pembinaan', 
        ModelPembinaanHandler::class
    ],
    ResourceEnum::ADMIN_MODEL_PEMBINAAN_ENTRY => [
        ['GET', 'POST'], 
        '/internal/model-pembinaan/entri', 
        [ModelPembinaanHandler::class, 'entry']
    ],
    ResourceEnum::ADMIN_MODEL_PEMBINAAN_EDIT => [
        ['GET', 'POST'], 
        '/internal/model-pembinaan/edit/{id:\d+}', 
        [ModelPembinaanHandler::class, 'edit']
    ],
    ResourceEnum::ADMIN_MODEL_PEMBINAAN_DELETE => [
        ['GET', 'POST'], 
        '/internal/model-pembinaan/delete/{id:\d+}', 
        [ModelPembinaanHandler::class, 'delete']
    ],

    ResourceEnum::ADMIN_STATUS_PERMINTAAN_LIST => [
        'GET', 
        '/internal/status-permintaan', 
        StatusPermintaanHandler::class
    ],
    ResourceEnum::ADMIN_STATUS_PERMINTAAN_ENTRY => [
        ['GET', 'POST'], 
        '/internal/status-permintaan/entri', 
        [StatusPermintaanHandler::class, 'entry']
    ],
    ResourceEnum::ADMIN_STATUS_PERMINTAAN_EDIT => [
        ['GET', 'POST'], 
        '/internal/status-permintaan/edit/{id:\d+}', 
        [StatusPermintaanHandler::class, 'edit']
    ],
    ResourceEnum::ADMIN_STATUS_PERMINTAAN_DELETE => [
        ['GET', 'POST'], 
        '/internal/status-permintaan/delete/{id:\d+}', 
        [StatusPermintaanHandler::class, 'delete']
    ],

    ResourceEnum::ADMIN_TINGKAT_INSTANSI_LIST => [
        'GET', 
        '/internal/tingkat-instansi', 
        TingkatInstansiHandler::class
    ],
    ResourceEnum::ADMIN_TINGKAT_INSTANSI_ENTRY => [
        ['GET', 'POST'], 
        '/internal/tingkat-instansi/entri', 
        [TingkatInstansiHandler::class, 'entry']
    ],
    ResourceEnum::ADMIN_TINGKAT_INSTANSI_EDIT => [
        ['GET', 'POST'], 
        '/internal/tingkat-instansi/edit/{id:\d+}', 
        [TingkatInstansiHandler::class, 'edit']
    ],
    ResourceEnum::ADMIN_TINGKAT_INSTANSI_DELETE => [
        ['GET', 'POST'], 
        '/internal/tingkat-instansi/delete/{id:\d+}', 
        [TingkatInstansiHandler::class, 'delete']
    ],
];
