<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 27/07/2016
 * Time: 15:54
 */

if (isset($_POST['action'])) {

    global $DBH, $DBT;
    include_once('app/class.dbTable.php');
    include_once('app/dbSpec/db.tables.php');
    $tbPokegender = new dbTable($DBH,'pokegender',$DBT['pokegender']);
    $tbPokedex = new dbTable($DBH,'pokedex',$DBT['pokedex']);

    switch ($_POST['action']) {
        case 'Build':

            break;
    }
}
