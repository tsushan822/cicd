<?php
return [
    'name' => 'Support',
    'password' => env('DEFAULT_SUPERADMIN_PASSWORD','zentreasury'),
    'email' => env('SUPER_ADMIN_EMAIL','support@zentreasury.com'),
    'verified' => '1',
    'must_change_password' => '1',
    'locale' => 'en',
];