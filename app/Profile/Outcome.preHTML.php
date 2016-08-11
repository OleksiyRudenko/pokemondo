<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 11/08/2016
 * Time: 19:51
 */
include_once('appid.gitignored.php');
include_once('app/class.Pokemon.php');
include_once('app/class.UsermonProfile.php');

if (!USER::$u['idnative']) {
    // not a registered user
    $fb=false;
    if ($fb) {
        //TODO: fb login callback handler
        /*
        if (!exists(fbUserId))
            createUser(fbUser)
          currentUser=getUser(fbUserId)
          redirect(outcome/ + currentUser.uid)
        */
    }
} else {
    // is registered user
    if (!UsermonProfile::$currentProfile) {
        // create user pokemon profile
        if (USER::$u['idnative']) {
            USER::loadPokemon();
            UsermonProfile::$currentProfile = new UsermonProfile(USER::$u['idnative'],USER::$u['name'],'x',USER::$u['birthdate']);
            UsermonProfile::$currentProfile->currentPokemon = &USER::$pokemon;
        }
    }
    logMessage('OUTCOME','UsermonProfile: '.varExport(UsermonProfile::$currentProfile),'info');
    logMessage('OUTCOME','User: '.varExport(USER::$u),'info');

    if (!count(ARGV::$a)) {
        logMessage('OUTCOME','Should redirect as '.varExport(ARGV::$a));
        // redirectLocal(MODULE::$currTreeProps['uri'].'/'.USER::getUrlId());
    } else {
        if (ARGV::$a[0]==USER::getUrlId()) {
            // requested id belongs to current user

            $pokelist = UsermonProfile::$currentProfile->selectPokemons();
            // remove pokemons randomly until count()=4
            $ini = count($pokelist)-1;
            while (count($pokelist)>4) {
                unset($pokelist[rand(0,$ini)]);
            }

            // this will be used for profile build or just skipped
            $candidatePokemon = array_pop($pokelist);

            if (!UsermonProfile::$currentProfile->userProfileImageExists() || isset(ARGV::$a[1])) {
                // profile image doesn't exist or pokename provided

                if (isset(ARGV::$a[1])) {
                    $pokemon = Pokemon::loadPokemon(ARGV::$a[1]);
                }

                UsermonProfile::$currentProfile->currentPokemon = ($pokemon)
                    ? $pokemon
                    : $candidatePokemon;
                // logMessage('Profile',varExport($pokeMain));
                // create image based on tpl
                UsermonProfile::$currentProfile->createProfileImg();
                // logMessage('Profile',varExport(UsermonProfile::$pokemonList));
            }
            // save remaining pokemons
            UsermonProfile::$pokemonList = $pokelist;
            // redirect
            if (isset(ARGV::$a[1]))
                redirectLocal(MODULE::$currTreeProps['uri'].'/'.USER::getUrlId());
        }
    }
}

