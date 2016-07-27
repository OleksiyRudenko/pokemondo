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

$dbtbDependeciesExist = true;
$dbtbMainExists = true;
if (!$tbPokegender->exists()) {
    $dbtbDependeciesExist = false;
    print alert('Required table `pokegender` doesn\'t exist. Please, complete '. ahref(MODULE::getSetting('url','fetch-genders'),'Fetch Gender Data'));
}
if (!$tbPokedex->exists()) {
    $dbtbMainExists = false;
    print alert('DB TABLE `pokedex` doesn\'t exist');
}

print unlogMessage('Pokedex');
// print varExport($_POST);

if ($dbtbDependeciesExist) {
    // proceed only if dependencies exist
    ?>
    <form method="POST">
        <?=buttonSubmit('Build',($dbtbMainExists?'ReBuild':'CREATE'))?>
    </form>
    <?php
    if ($dbtbMainExists) {

    }
}

// show paginated data

$qr=$tbPokedex->count();