<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'admins',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | You may define every authentication guard for your application here.
    | We're using Sanctum for API token authentication for each user type.
    |
    */

    'guards' => [
        'web' => [
            'driver'   => 'session',
            'provider' => 'admins', // default web guard (can be changed)
        ],

        'admin' => [
            'driver'   => 'sanctum',
            'provider' => 'admins',
        ],

        'teacher' => [
            'driver'   => 'sanctum',
            'provider' => 'teachers',
        ],

        'student' => [
            'driver'   => 'sanctum',
            'provider' => 'students',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Here you may define how the users are retrieved out of your database.
    | Each provider corresponds to a different model and table.
    |
    */

    'providers' => [
        'admins' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Admin::class,
        ],

        'teachers' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Teacher::class,
        ],

        'students' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Student::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may set up separate password reset settings for each user type.
    | By default, all use the same `password_reset_tokens` table.
    |
    */

    'passwords' => [
        'admins' => [
            'provider' => 'admins',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],

        'teachers' => [
            'provider' => 'teachers',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],

        'students' => [
            'provider' => 'students',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | The number of seconds before password confirmation times out.
    |
    */

    'password_timeout' => 10800,

];
