<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 09/08/2016
 * Time: 12:37
 */

$_SESSION['user'] = [];
USER::initialize();
redirectLocal(USER::$uri['onLogout']);