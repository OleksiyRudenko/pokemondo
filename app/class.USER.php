<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 08/08/2016
 * Time: 17:22
 */

define('UMASK_GUEST',1);
define('UMASK_REGISTERED',2);
define('UMASK_ADMIN',4);
define('UMASK_ROOT',128);

class USER {
    public static $u;
    public static $uri = [
        'onFailure'     =>  0,
        'onSuccess'     =>  '/manage',
        'authRequired'  =>  '/login',
    ];

    public static function initialize() {
        session_start();
        if (!isset($_SESSION['user'])) {
            $_SESSION['user']=[];
        }
        self::$u = &$_SESSION['user'];
        if (!isset(self::$u['umask']))
            self::$u['umask'] = UMASK_GUEST; // guest

    }

    public static function login($login,$password) {
        if ($login=='orudenko@bigmir.net' && $password=='zaq12wsx') {
            self::$u['umask'] = UMASK_ROOT; // superuser
            redirectLocal(self::$uri['onSuccess']);
            return true;
        }

        return false;
    }

}