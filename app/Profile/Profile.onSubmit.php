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
            $uprofile = new UsermonProfile($_POST['userid'],$_POST['username'],$_POST['gender'],$_POST['birthdate']);
            UsermonProfile::$pokemonList = $uprofile->selectPokemons();
            // logMessage('Profile',varExport($u->selectPokemons()));
            break;
    }

}



