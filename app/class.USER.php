<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 08/08/2016
 * Time: 17:22
 */


define('UMASK_GUEST',         1);
define('UMASK_REGISTERED',    2);
define('UMASK_ADMIN',64);
define('UMASK_ROOT',128);

define('USER_GUEST',1);
define('USER_REGISTERED',3);
define('USER_ADMIN',7);
define('USER_ROOT',0xffff);

class USER {
    public static $u;           // particular user settings
    public static $uri = [
        'onFailure'     =>  0,
        'onSuccess'     =>  [   // if bit is set then value is upon login redirection target; higher come first
            0x8000      =>  '/users',
            0x0800      =>  '/manage',
        ],
        'onLogout'      =>  '/',
        'authRequired'  =>  '/login',
    ];
    public static $AUTH = [
        'access'    => [
            'guest'      =>  0x0001,
            'registered' =>  0x0002,
            'admin'      =>  0x0800,
            'root'       =>  0x8000,
        ],
        'powers'    => [
            'guest'      =>  0x0001,
            'registered' =>  0x0003,
            'admin'      =>  0x0fff,
            'root'       =>  0xffff,
        ],
    ];

    public static function initialize() {
        session_start();
        if (!isset($_SESSION['user'])) {
            $_SESSION['user']=[];
        }
        self::$u = &$_SESSION['user'];
        if (!isset(self::$u['upowers']))
            self::$u['upowers'] = self::$AUTH['powers']['guest']; // guest
    }

    public static function getUponLoginDefaultUri() {
        foreach (self::$uri['onSuccess'] as $mask=>$uri)
            if (self::$u['upowers']&$mask)
                return $uri;
        return '/'; // server root
    }

    public static function login($login,$password) {
        global $DBH, $DBT;
        include_once('app/class.dbTable.php');
        include_once('app/dbSpec/db.tables.php');

        $success = false;

        $clauses = [
            'WHERE' =>  'uname=\''.$DBH->real_escape_string($login).'\'',
        ];
        $tbUnative = new dbTable($DBH,'unative',$DBT['unative']);
        if (!$qr=$tbUnative->select('*',$clauses)) {
            return false;
        }
        if ($qr->num_rows==0) {
            $qr->free();
            return false;
        }

        $credentials = $qr->fetch_assoc();
        if (md5(md5($credentials['usalt']).md5($password))===$credentials['upwdhash']) {
            self::$u['name'] = $credentials['uname'];
            self::$u['upowers'] = $credentials['upowers'];
            $success = true;
        }
        /*
        if ($login=='admin' && $password=='zaq12wsx') {
            self::$u['name'] = 'admin';
            self::$u['upowers'] = USER_ADMIN; // admin
            $success = true;
        }

        if ($login=='root' && $password=='zaq12wsx') {
            self::$u['name'] = 'root';
            self::$u['upowers'] = USER_ROOT; // superuser
            $success = true;
        } */

        $qr->free();

        if ($success) {
            $redirectTo = @self::$u['redirectUponLogin']
                ?self::$u['redirectUponLogin']
                :self::getUponLoginDefaultUri();
            if (@self::$u['redirectUponLogin'])
                self::$u['redirectUponLogin']=0;
            redirectLocal($redirectTo);
            return true; // won't be reached as redirectLocal exits
        }

        return $success;
    }

    public static function setRedirectUponLogin($uri) {
        self::$u['redirectUponLogin'] = $uri;
    }

}