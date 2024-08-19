<?php

declare (strict_types=1);

namespace App\Enums;

use Faster\Component\Enums\BaseEnum;

/**
 * ResourceEnum
 * 
 * Resource value must be unique, use short string
 */
class ResourceEnum extends BaseEnum
{
    /** frontend */
    public const MAINTENANCE = 'mt';
    public const HOME = 'h';
    public const METADATA = 'm';
    public const ROMANTIK = 'r';
    public const GSBPM = 'g';

    public const MODUL_PEMBINAAN_LIST = 'mp_l';
    public const MODUL_LITERASI_LIST = 'ml_l';

    public const PERMINTAAN_PEMBINAAN_LIST = 'pp_l';
    public const PERMINTAAN_PEMBINAAN_ENTRY = 'pp_y';
    public const PERMINTAAN_PEMBINAAN_VIEW = 'pp_v';
    public const PERMINTAAN_PEMBINAAN_EDIT = 'pp_e';
    public const PERMINTAAN_PEMBINAAN_DELETE = 'pp_d';
    public const PESAN_PERMINTAAN_PEMBINAAN_POST = 'ppp_p';

    public const DOKUMENTASI_PEMBINAAN_LIST = 'dp_l';
    public const DOKUMENTASI_PEMBINAAN_VIEW = 'dp_v';

    public const TESTIMONI = 't';
    public const TESTIMONI_POST = 't_p';
    
    public const USER_INFO = 'u_i';
    public const USER_UPDATE = 'u_u';

    public const LOGIN = 'lg';
    public const LOGIN_SSO = 'ls';
    public const RESET_PASSWORD = 'rp';
    public const DO_RESET_PASSWORD = 'drp';
    public const LOGOUT = 'lo';
    public const REGISTER = 'rg';
    public const ACTIVATION = 'ac';

    /** backend */
    public const DASHBOARD = 'd';

    public const ADMIN_PERMINTAAN_PEMBINAAN_LIST = 'app_l';
    public const ADMIN_PERMINTAAN_PEMBINAAN_VIEW = 'app_v';
    public const ADMIN_PERMINTAAN_PEMBINAAN_EDIT = 'app_e';
    public const ADMIN_PERMINTAAN_PEMBINAAN_DELETE = 'app_d';

    public const ADMIN_PESAN_PERMINTAAN_PEMBINAAN_POST = 'appp_p';
    public const ADMIN_STATUS_PERMINTAAN_PEMBINAAN_EDIT = 'aspp_e';

    public const ADMIN_USER_LIST = 'au_l';
    public const ADMIN_USER_INFO = 'au_i';
    public const ADMIN_USER_VIEW = 'au_v';
    public const ADMIN_USER_DELETE = 'au_d';
    public const ADMIN_USER_EDIT = 'au_e';
    public const ADMIN_ROLE_LIST = 'ar_l';

    public const ADMIN_MODUL_GSBPM_LIST = 'amg_l';
    public const ADMIN_MODUL_GSBPM_EDIT = 'amg_e';

    public const ADMIN_MODUL_PEMBINAAN_LIST = 'amp_l';
    public const ADMIN_MODUL_PEMBINAAN_ENTRY = 'amp_y';
    public const ADMIN_MODUL_PEMBINAAN_DELETE = 'amp_d';
    public const ADMIN_MODUL_PEMBINAAN_EDIT = 'amp_e';
    public const ADMIN_MODUL_PEMBINAAN_APPROVE = 'amp_a';

    public const ADMIN_MODUL_LITERASI_LIST = 'aml_l';
    public const ADMIN_MODUL_LITERASI_ENTRY = 'aml_y';
    public const ADMIN_MODUL_LITERASI_DELETE = 'aml_d';
    public const ADMIN_MODUL_LITERASI_EDIT = 'aml_e';
    public const ADMIN_MODUL_LITERASI_APPROVE = 'aml_a';

    public const ADMIN_DOKUMENTASI_LIST = 'ad_l';
    public const ADMIN_DOKUMENTASI_ENTRY = 'ad_y';
    public const ADMIN_DOKUMENTASI_VIEW = 'ad_v';
    public const ADMIN_DOKUMENTASI_DELETE = 'ad_d';
    public const ADMIN_DOKUMENTASI_EDIT = 'ad_e';
    public const ADMIN_DOKUMENTASI_APPROVE = 'ad_a';

    public const ADMIN_TESTIMONI_LIST = 'at_l';
    public const ADMIN_TESTIMONI_DELETE = 'at_d';
    public const ADMIN_TESTIMONI_EDIT = 'at_e';

    public const ADMIN_KATEGORI_MODUL_PEMBINAAN_LIST = 'akmp_l';
    public const ADMIN_KATEGORI_MODUL_PEMBINAAN_ENTRY = 'akmp_y';
    public const ADMIN_KATEGORI_MODUL_PEMBINAAN_DELETE = 'akmp_d';
    public const ADMIN_KATEGORI_MODUL_PEMBINAAN_EDIT = 'akmp_e';

    public const ADMIN_KATEGORI_MODUL_LITERASI_LIST = 'akml_l';
    public const ADMIN_KATEGORI_MODUL_LITERASI_ENTRY = 'akml_y';
    public const ADMIN_KATEGORI_MODUL_LITERASI_DELETE = 'akml_d';
    public const ADMIN_KATEGORI_MODUL_LITERASI_EDIT = 'akml_e';

    public const ADMIN_MODEL_PEMBINAAN_LIST = 'admp_l';
    public const ADMIN_MODEL_PEMBINAAN_ENTRY = 'admp_y';
    public const ADMIN_MODEL_PEMBINAAN_DELETE = 'admp_d';
    public const ADMIN_MODEL_PEMBINAAN_EDIT = 'admp_e';

    public const ADMIN_STATUS_PERMINTAAN_LIST = 'asp_l';
    public const ADMIN_STATUS_PERMINTAAN_ENTRY = 'asp_y';
    public const ADMIN_STATUS_PERMINTAAN_DELETE = 'asp_d';
    public const ADMIN_STATUS_PERMINTAAN_EDIT = 'asp_e';

    public const ADMIN_TINGKAT_INSTANSI_LIST = 'ati_l';
    public const ADMIN_TINGKAT_INSTANSI_ENTRY = 'ati_y';
    public const ADMIN_TINGKAT_INSTANSI_DELETE = 'ati_d';
    public const ADMIN_TINGKAT_INSTANSI_EDIT = 'ati_e';
}