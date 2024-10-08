<?php

declare(strict_types=1);

use App\Enums\ResourceEnum;
use App\Enums\RoleEnum;

return [
    RoleEnum::USER => [
        ResourceEnum::PERMINTAAN_PEMBINAAN_LIST, 
        ResourceEnum::PERMINTAAN_PEMBINAAN_ENTRY,
        ResourceEnum::PERMINTAAN_PEMBINAAN_VIEW,
        ResourceEnum::PERMINTAAN_PEMBINAAN_EDIT,
        ResourceEnum::PESAN_PERMINTAAN_PEMBINAAN_POST,
        ResourceEnum::PERMINTAAN_PEMBINAAN_DELETE,
        ResourceEnum::TESTIMONI_POST,
        ResourceEnum::USER_INFO,
    ],
    RoleEnum::OPERATOR => [
        ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_LIST,
        ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_VIEW,
        ResourceEnum::ADMIN_PESAN_PERMINTAAN_PEMBINAAN_POST,
        ResourceEnum::ADMIN_STATUS_PERMINTAAN_PEMBINAAN_EDIT,
        ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_DELETE,
        ResourceEnum::DASHBOARD,
        ResourceEnum::ADMIN_USER_INFO,
        ResourceEnum::ADMIN_MODUL_GSBPM_LIST,
        ResourceEnum::ADMIN_MODUL_GSBPM_EDIT,
        ResourceEnum::ADMIN_MODUL_PEMBINAAN_LIST,
        ResourceEnum::ADMIN_MODUL_PEMBINAAN_ENTRY,
        ResourceEnum::ADMIN_MODUL_PEMBINAAN_DELETE,
        ResourceEnum::ADMIN_MODUL_PEMBINAAN_EDIT,
        ResourceEnum::ADMIN_MODUL_LITERASI_LIST,
        ResourceEnum::ADMIN_MODUL_LITERASI_ENTRY,
        ResourceEnum::ADMIN_MODUL_LITERASI_DELETE,
        ResourceEnum::ADMIN_MODUL_LITERASI_EDIT,
        ResourceEnum::ADMIN_DOKUMENTASI_LIST,
        ResourceEnum::ADMIN_DOKUMENTASI_ENTRY,
        ResourceEnum::ADMIN_DOKUMENTASI_DELETE,
        ResourceEnum::ADMIN_DOKUMENTASI_EDIT,
        ResourceEnum::ADMIN_DOKUMENTASI_VIEW,
        ResourceEnum::ADMIN_TESTIMONI_LIST,
        ResourceEnum::ADMIN_TESTIMONI_DELETE,
        ResourceEnum::ADMIN_TESTIMONI_EDIT,
        ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_LIST,
        ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_ENTRY,
        ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_DELETE,
        ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_EDIT,
        ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_LIST,
        ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_ENTRY,
        ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_EDIT,
        ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_DELETE,
        ResourceEnum::ADMIN_MODEL_PEMBINAAN_LIST,
        ResourceEnum::ADMIN_MODEL_PEMBINAAN_ENTRY,
        ResourceEnum::ADMIN_MODEL_PEMBINAAN_DELETE,
        ResourceEnum::ADMIN_MODEL_PEMBINAAN_EDIT,
        ResourceEnum::ADMIN_STATUS_PERMINTAAN_LIST,
        ResourceEnum::ADMIN_STATUS_PERMINTAAN_ENTRY,
        ResourceEnum::ADMIN_STATUS_PERMINTAAN_EDIT,
        ResourceEnum::ADMIN_STATUS_PERMINTAAN_DELETE,
        ResourceEnum::ADMIN_TINGKAT_INSTANSI_LIST,
        ResourceEnum::ADMIN_TINGKAT_INSTANSI_ENTRY,
        ResourceEnum::ADMIN_TINGKAT_INSTANSI_DELETE,
        ResourceEnum::ADMIN_TINGKAT_INSTANSI_EDIT,
    ],
    RoleEnum::SUPERVISOR => [
        ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_LIST,
        ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_VIEW,
        ResourceEnum::ADMIN_PESAN_PERMINTAAN_PEMBINAAN_POST,
        ResourceEnum::ADMIN_STATUS_PERMINTAAN_PEMBINAAN_EDIT,
        ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_DELETE,
        ResourceEnum::DASHBOARD,
        ResourceEnum::ADMIN_USER_INFO,
        ResourceEnum::ADMIN_MODUL_GSBPM_LIST,
        ResourceEnum::ADMIN_MODUL_GSBPM_EDIT,
        ResourceEnum::ADMIN_MODUL_PEMBINAAN_LIST,
        ResourceEnum::ADMIN_MODUL_PEMBINAAN_ENTRY,
        ResourceEnum::ADMIN_MODUL_PEMBINAAN_DELETE,
        ResourceEnum::ADMIN_MODUL_PEMBINAAN_EDIT,
        ResourceEnum::ADMIN_MODUL_PEMBINAAN_APPROVE,
        ResourceEnum::ADMIN_MODUL_LITERASI_LIST,
        ResourceEnum::ADMIN_MODUL_LITERASI_ENTRY,
        ResourceEnum::ADMIN_MODUL_LITERASI_DELETE,
        ResourceEnum::ADMIN_MODUL_LITERASI_EDIT,
        ResourceEnum::ADMIN_MODUL_LITERASI_APPROVE,
        ResourceEnum::ADMIN_DOKUMENTASI_LIST,
        ResourceEnum::ADMIN_DOKUMENTASI_ENTRY,
        ResourceEnum::ADMIN_DOKUMENTASI_DELETE,
        ResourceEnum::ADMIN_DOKUMENTASI_EDIT,
        ResourceEnum::ADMIN_DOKUMENTASI_VIEW,
        ResourceEnum::ADMIN_DOKUMENTASI_APPROVE,
        ResourceEnum::ADMIN_TESTIMONI_LIST,
        ResourceEnum::ADMIN_TESTIMONI_DELETE,
        ResourceEnum::ADMIN_TESTIMONI_EDIT,
        ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_LIST,
        ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_ENTRY,
        ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_DELETE,
        ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_EDIT,
        ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_LIST,
        ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_ENTRY,
        ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_EDIT,
        ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_DELETE,
        ResourceEnum::ADMIN_MODEL_PEMBINAAN_LIST,
        ResourceEnum::ADMIN_MODEL_PEMBINAAN_ENTRY,
        ResourceEnum::ADMIN_MODEL_PEMBINAAN_DELETE,
        ResourceEnum::ADMIN_MODEL_PEMBINAAN_EDIT,
        ResourceEnum::ADMIN_STATUS_PERMINTAAN_LIST,
        ResourceEnum::ADMIN_STATUS_PERMINTAAN_ENTRY,
        ResourceEnum::ADMIN_STATUS_PERMINTAAN_EDIT,
        ResourceEnum::ADMIN_STATUS_PERMINTAAN_DELETE,
        ResourceEnum::ADMIN_TINGKAT_INSTANSI_LIST,
        ResourceEnum::ADMIN_TINGKAT_INSTANSI_ENTRY,
        ResourceEnum::ADMIN_TINGKAT_INSTANSI_DELETE,
        ResourceEnum::ADMIN_TINGKAT_INSTANSI_EDIT,
    ],
    RoleEnum::VIEWER => [
        ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_LIST,
        ResourceEnum::ADMIN_PERMINTAAN_PEMBINAAN_VIEW,
        ResourceEnum::DASHBOARD,
        ResourceEnum::ADMIN_USER_INFO,
        ResourceEnum::ADMIN_MODUL_GSBPM_LIST,
        ResourceEnum::ADMIN_MODUL_PEMBINAAN_LIST,
        ResourceEnum::ADMIN_MODUL_LITERASI_LIST,
        ResourceEnum::ADMIN_DOKUMENTASI_LIST,
        ResourceEnum::ADMIN_DOKUMENTASI_VIEW,
        ResourceEnum::ADMIN_TESTIMONI_LIST,
        ResourceEnum::ADMIN_KATEGORI_MODUL_PEMBINAAN_LIST,
        ResourceEnum::ADMIN_KATEGORI_MODUL_LITERASI_LIST,
        ResourceEnum::ADMIN_MODEL_PEMBINAAN_LIST,
        ResourceEnum::ADMIN_STATUS_PERMINTAAN_LIST,
        ResourceEnum::ADMIN_TINGKAT_INSTANSI_LIST,
    ],
    RoleEnum::ADMIN => [
        ResourceEnum::ADMIN_USER_LIST,
        ResourceEnum::ADMIN_USER_INFO,
        ResourceEnum::ADMIN_USER_VIEW,
        ResourceEnum::ADMIN_USER_DELETE,
        ResourceEnum::ADMIN_USER_EDIT,
        ResourceEnum::ADMIN_ROLE_LIST
    ]
];
