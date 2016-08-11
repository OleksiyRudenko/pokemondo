<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 02/08/2016
 * Time: 17:55
 */

if (isset($_POST['action'])) {

    global $DBH, $DBT;
    include_once('app/class.dbTable.php');
    include_once('app/dbSpec/db.tables.php');
    include_once('app/class.Pokemon.php');
    include_once('app/class.UsermonProfile.php');

    switch ($_POST['action']) {
        case 'Process':
            UsermonProfile::$currentProfile = new UsermonProfile($_POST['userid'],$_POST['username'],$_POST['gender'],$_POST['birthdate']);
            $pokelist = UsermonProfile::$currentProfile->selectPokemons();
            // remove pokemons randomly until count()=4
            $ini = count($pokelist)-1;
            while (count($pokelist)>4) {
                unset($pokelist[rand(0,$ini)]);
            }
            // complete pokemons with types

            // create image based on tpl
            UsermonProfile::$currentProfile->currentPokemon = array_pop($pokelist);
            // logMessage('Profile',varExport($pokeMain));
            UsermonProfile::$currentProfile->createProfileImg();
            // save remaining pokemons
            UsermonProfile::$pokemonList = $pokelist;
            // logMessage('Profile',varExport(UsermonProfile::$pokemonList));
            break;
    }

}



