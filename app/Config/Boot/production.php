<?php

/*
|--------------------------------------------------------------------------
| ERROR DISPLAY
|--------------------------------------------------------------------------
| Don't show ANY in production environments. Instead, let the system catch
| it and display a generic error message.
 */
ini_set('display_errors', '0');
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);

/*
|--------------------------------------------------------------------------
| DEBUG MODE
|--------------------------------------------------------------------------
| Debug mode is an experimental flag that can allow changes throughout
| the system. It's not widely used currently, and may not survive
| release of the framework.
 */

defined('CI_DEBUG') || define('CI_DEBUG', 0);

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
        'DBDebug' => false,
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
defined('TOKEN_EXPIRE') || define('TOKEN_EXPIRE', 15);
defined('REFRESH_TOKEN_EXPIRE') || define('REFRESH_TOKEN_EXPIRE', 30);
defined('VERIFY_TOKEN_EXPIRE') || define('VERIFY_TOKEN_EXPIRE', 60 * 24);
defined('FORGOT_TOKEN_EXPIRE') || define('FORGOT_TOKEN_EXPIRE', 60 * 24);
defined('JWT_KEY') || define('JWT_KEY', 'a3ljZm9ynqowASDOYWlzcHJvZA==');
defined('JWT_ALGORITHM') || define('JWT_ALGORITHM', 'HS256');
