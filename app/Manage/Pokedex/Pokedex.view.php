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

// check if dependecy tables exist
$dbTb = ['pokegender'=>0,'pokename'=>0];
$redirect = [
    'pokegender'=> [ 'url'=>MODULE::getSetting('url','fetch-genders'),
        'text' => 'fetch Gender Data', ],
    'pokename'=>    [ 'url'=>MODULE::getSetting('url','fetch-pokemons'),
        'text' => 'fetch Pokemon Data', ],
];
$dbtbDependeciesExist = true;
foreach (array_keys($dbTb) as $i=>$tbname) {
    $dbTb[$tbname] = new dbTable($DBH,$tbname,$DBT[$tbname]);
    if (!$dbTb[$tbname]->exists()) {
        $dbtbDependeciesExist = false;
        print alert('Required table `'.$tbname.'` doesn\'t exist. Please, '
            .ahref($redirect[$tbname]['url'],$redirect[$tbname]['text']));
    }
}

// check if major table exists
$dbtbMainExists = true;
$tbPokedex = new dbTable($DBH,'pokedex',$DBT['pokedex']);
if (!$tbPokedex->exists()) {
    $dbtbMainExists = false;
    print alert('DB TABLE `pokedex` doesn\'t exist');
}

print unlogMessage('Pokedex');
// print varExport($_POST);

// CREATE/ReBuild Button
if ($dbtbDependeciesExist) {
    // proceed only if dependencies exist
    ?>
    <form method="POST">
        <?=buttonSubmit('Build',($dbtbMainExists?'ReBuild':'CREATE'),($dbtbMainExists?'danger':'primary'))?>
    </form>
    <?php
    if ($dbtbMainExists) {
        if (($rowCount=$tbPokedex->countRows('pokeid'))===false) {
            print alert('Cannot access `pokedex`!');
        } else {
            // show paginated data
            include 'app/Manage/Pokedex/Pokedex.view.browse.php';

        }
    }
}