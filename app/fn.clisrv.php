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

function redirect($url=false) {

}