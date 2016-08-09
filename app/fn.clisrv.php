<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 27/07/2016
 * Time: 16:00
 */

function assignCookie($cookiename,$cookievalue,$lifespan=false) {
    if (!$lifespan) $lifespan = time()+60*60*24*180; // 180 days by default
    setcookie($cookiename,$cookievalue,$lifespan);
    $_COOKIE[$cookiename]=$cookievalue;
}

function redirectLocal($uri) {
    header('Location: '.getFullServerName().($uri[0]=='/'?'':'/').$uri);
    exit;
}

/**
 * @param $request : $_GET|POST|REQUEST
 * @param $var : [ key=>value,...]
 */
function assignRequestPresets(&$request, $var) {
    foreach ($var as $k=>$v)
        if (!isset($request[$k]))
            $request[$k]=$v;
}

function getFullServerName() {
    return $_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["SERVER_NAME"]
    .($_SERVER["SERVER_PORT"]?':'.$_SERVER["SERVER_PORT"]:'')
    ;
}