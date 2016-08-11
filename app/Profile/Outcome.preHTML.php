<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 11/08/2016
 * Time: 19:51
 */

include_once('app/class.Pokemon.php');
include_once('app/class.UsermonProfile.php');

if (!UsermonProfile::$currentProfile) {
    // create profile
    if (USER::$u) {

        UsermonProfile::$currentProfile = new UsermonProfile($_POST['userid'],$_POST['username'],$_POST['gender'],$_POST['birthdate']);
    }
}