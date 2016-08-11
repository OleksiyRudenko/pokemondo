<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 11/08/2016
 * Time: 19:51
 */
include_once ('appid.gitignored.php');
include_once('app/class.Pokemon.php');
include_once('app/class.UsermonProfile.php');

if (!USER::$u['idnative']) {
    // is guest


}

if (!UsermonProfile::$currentProfile) {
    // create profile
    if (USER::$u['idnative']) {
        USER::loadPokemon();
        UsermonProfile::$currentProfile = new UsermonProfile(USER::$u['idnative'],USER::$u['name'],'x',USER::$u['birthdate']);
        UsermonProfile::$currentProfile->currentPokemon = &USER::$pokemon;
    }
}