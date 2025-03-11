<?php

return [
    'pdf' => [
        'enabled' => true,
        'binary' => '/usr/bin/wkhtmltopdf', // Specify the path to wkhtmltopdf
        'timeout' => false,
        'options' => [
            'enable-local-file-access' => true,
            'page-size' => 'A4',
            'margin-top' => 10,
            'margin-right' => 10,
            'margin-bottom' => 10,
            'margin-left' => 10,
            'encoding' => 'UTF-8',
        ],
        'env' => [],
    ],
    'image' => [
        'enabled' => true,
        'binary' => '/usr/bin/wkhtmltoimage',
        'timeout' => false,
        'options' => [],
        'env' => [],
    ],
];