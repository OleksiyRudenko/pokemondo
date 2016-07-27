<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 27/07/2016
 * Time: 15:54
 */

global $DBH, $DBT;
include_once('app/class.dbTable.php');
include_once('app/dbSpec/db.tables.php');
$tbPokegender = new dbTable($DBH,'pokegender',$DBT['pokegender']);
$tbPokedex = new dbTable($DBH,'pokedex',$DBT['pokedex']);

$dbtbDependeciesExists = true;
$dbtbTargetExists = true;
if (!$tbPokegender->exists()) {
    print alert('Required table `pokegender` doesn\'t exist. Please, complete Fetch Gender Data');
}
if (!$tbPokedex->exists()) {
    $populate = true;
    $tbPokegender->create();
    print alert('Create TABLE pokegender','info');
}