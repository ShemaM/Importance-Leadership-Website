<?php
// config.php
return [
    'database' => [
        'host' => 'localhost',
        'name' => 'importanceleadership',
        'user' => 'root',
        'pass' => 'secret',
        'charset' => 'utf8mb4'
    ],
    'email' => [
        'to' => 'importanceleadership2020@gmail.com',
        'from' => 'noreply@importanceleadership.com',
        'subject_prefix' => '[Contact Form] '
    ],
    'security' => [
        'honeypot_field' => 'website_url',
        'csrf' => true
    ]
    
];