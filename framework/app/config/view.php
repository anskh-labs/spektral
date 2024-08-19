<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface;

return [
    'pagination' => [
        'per_page' => 10
    ],
    'maintenance' => function (ResponseInterface $response) {
        return render('maintenance', ['title' => 'Maintenance | SPEKTRAL'], $response);
    }
];
