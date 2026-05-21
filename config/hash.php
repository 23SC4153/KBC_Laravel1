<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Hash Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default hash driver that will be used to hash
    | passwords for your application. By default, the bcrypt algorithm is
    | used; however, you remain free to modify this option if you wish.
    |
    | Supported: "bcrypt", "argon", "argon2id"
    |
    */

    'driver' => 'argon2id',

    /*
    |--------------------------------------------------------------------------
    | Bcrypt Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify the options that should be passed to the Bcrypt
    | hashing algorithm. This will allow you to control the amount of time
    | it takes to hash the given password.
    |
    */

    'bcrypt' => [
        'rounds' => env('BCRYPT_ROUNDS', 12),
        'verify' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Argon Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify the options that should be passed to the Argon
    | hashing algorithm. These will allow you to control the amount of
    | time it takes to hash the given password.
    |
    */

    'argon' => [
        'memory' => 1024,
        'threads' => 2,
        'time' => 2,
        'verify' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Argon2ID Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify the options that should be passed to the Argon2ID
    | hashing algorithm. These will allow you to control the amount of
    | time it takes to hash the given password.
    |
    */

    'argon2id' => [
        'memory' => 1024,
        'threads' => 2,
        'time' => 2,
        'verify' => true,
    ],

];
