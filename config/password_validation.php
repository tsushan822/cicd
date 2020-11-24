<?php

return [
    'min_length' => env('PASSWORD_MIN_LENGTH', 8),

    'max_length' => env('PASSWORD_MAX_LENGTH', 255),

    'pattern' => env('PASSWORD_PATTERN', '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'),

     /*Number after which unsuccessful login user should taken some action*/
    'number_of_unsuccessful_login' => 5,

    /*Duration after which user must change their password*/
    'password_change_days' => 60,

    'enable_change_password' => false,

    'enable_failed_login_lock' => false,
];