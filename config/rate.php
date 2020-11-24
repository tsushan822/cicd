<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 2020-0703
 * Time: 15:34
 */
return [
    'databond' => [
        'email' => env('DATABOND_EMAIL', 'admin@zentreasury.fi'),
        'password' => env('DATABOND_PASSWORD', '7#8pmQU#5NSby7#YF%j#'),
        'token' => env('DATABOND_TOKEN', '260000'),
    ],

    'fx_source' => ['ECB', 'Central Bank of Sweden'],
];