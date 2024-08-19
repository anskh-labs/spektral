<?php

declare(strict_types=1);

return [
    'reset_password' => [
        'subject' => 'Informasi Reset Password | SPEKTRAL',
        'html_message' => '<p>Halo %client_name%,</p><p>Kami telah menerima permintaan anda untuk mengatur ulang password.</p><p>Klik tautan di bawah ini untuk memasukkan password yang baru</p><p><a href="%client_url%" target="_blank">Ubah Sekarang</a></p><p>Terimakasih, BPS Provinsi Riau</p>'
    ],
    'register' => [
        'subject' => 'Informasi Registrasi Akun | SPEKTRAL',
        'html_message' => '<p>Halo %client_name%,</p><p>Terimakasih telah registrasi. Ini adalah jawaban otomatis sebagai konfirmasi bahwa registrasi Anda telah tersimpan di kami.</p><p>Klik tautan di bawah ini untuk memverifikasi akun email Anda untuk mendapatkan akses penuh pada SPEKTRAL BPS Provinsi Riau.</p><p><a href="%client_url%" target="_blank">Aktifkan Sekarang</a></p><p>Terimakasih, BPS Provinsi Riau</p>'
    ],
    'new_ticket' => [
        'subject' => 'Informasi Permintaan Pembinaan Baru | SPEKTRAL',
        'html_message' => '<p>Halo %client_name%,</p><p>Terimakasih telah menyampaikan permintaan pembinaan statistik sektoral di aplikasi SPEKTRAL. Ini adalah jawaban otomatis sebagai konfirmasi bahwa permintaan Anda telah tersimpan di kami. Kami akan segera menanggapi permintaan Anda maksimal 5 hari kerja sejak permintaan dibuat.</p><p>Klik tautan di bawah ini untuk memantau progress penanganan permintaan Anda.</p><p><a href="%client_url%" target="_blank">Lihat Sekarang</a></p><p>Terimakasih, BPS Provinsi Riau</p>'
    ],
    'new_ticket_notification' => [
        'subject' => 'Notifikasi Permintaan Pembinaan Baru | SPEKTRAL',
        'html_message' => '<p>Halo Supervisor SPEKTRAL,</p><p>Permintaan baru telah masuk di aplikasi SPEKTRAL. Silahkan lakukan penyelesaian permintaan maksimal 5 hari kerja sejak permintaan dibuat.</p><p>Klik tautan di bawah ini untuk menanggapi permintaan tersebut.</p><p><a href="%client_url%" target="_blank">Tanggapi Sekarang</a></p><p>Terimakasih, BPS Provinsi Riau</p>'
    ]
];