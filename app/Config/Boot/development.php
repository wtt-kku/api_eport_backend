<?php

/*
|--------------------------------------------------------------------------
| ERROR DISPLAY
|--------------------------------------------------------------------------
| In development, we want to show as many errors as possible to help
| make sure they don't make it to production. And save us hours of
| painful debugging.
 */
error_reporting(-1);
ini_set('display_errors', '1');

/*
|--------------------------------------------------------------------------
| DEBUG BACKTRACES
|--------------------------------------------------------------------------
| If true, this constant will tell the error screens to display debug
| backtraces along with the other error information. If you would
| prefer to not see this, set this value to false.
 */
defined('SHOW_DEBUG_BACKTRACE') || define('SHOW_DEBUG_BACKTRACE', true);

/*
|--------------------------------------------------------------------------
| DEBUG MODE
|--------------------------------------------------------------------------
| Debug mode is an experimental flag that can allow changes throughout
| the system. This will control whether Kint is loaded, and a few other
| items. It can always be used within your own application too.
 */

defined('CI_DEBUG') || define('CI_DEBUG', 1);

/*
|--------------------------------------------------------------------------
| DEFAULT DATABSE
|--------------------------------------------------------------------------
 */

define(
    'DEFAULT_DATABSE',
    array(
        'DSN' => '',
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'api_eportfolio',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug' => true,
        'cacheOn' => false,
        'cacheDir' => '',
        'charset' => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre' => '',
        'encrypt' => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port' => 3306
    ),
);


/*
|--------------------------------------------------------------------------
| TOKEN
|--------------------------------------------------------------------------
 */
defined('TOKEN_EXPIRE') || define('TOKEN_EXPIRE', 60 * 15);
defined('REFRESH_TOKEN_EXPIRE') || define('REFRESH_TOKEN_EXPIRE', 60 * 30);
defined('VERIFY_TOKEN_EXPIRE') || define('VERIFY_TOKEN_EXPIRE', 60 * 60 * 24);
defined('FORGOT_TOKEN_EXPIRE') || define('FORGOT_TOKEN_EXPIRE', 60 * 60 * 24);
defined('JWT_KEY') || define('JWT_KEY', 'coreblaster');
defined('JWT_ALGORITHM') || define('JWT_ALGORITHM', 'HS256');
