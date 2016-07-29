<p class="lead">Update `pokename` with pokename_ru data for pokemons that are already on the record.</p>
<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 29/07/2016
 * Time: 17:00
 */

global $DBH, $DBT;
include_once('app/class.dbTable.php');
include_once('app/dbSpec/db.tables.php');

// check if dependecy tables exist
$dbTbDep = ['pokename'=>0,];
$redirect = [
    'pokename'=> [ 'url'=>MODULE::getSetting('url','pokename'),
        'text' => 'create Pokename', ],
];
$dbtbDependeciesExist = true;
foreach (array_keys($dbTbDep) as $i=> $tbname) {
    $dbTbDep[$tbname] = new dbTable($DBH,$tbname,$DBT[$tbname]);
    if (!$dbTbDep[$tbname]->exists()) {
        $dbtbDependeciesExist = false;
        print alert('Required table `'.$tbname.'` doesn\'t exist. Please, '
            .ahref($redirect[$tbname]['url'],$redirect[$tbname]['text']));
    }
}

print unlogMessage('DBH');
print unlogMessage('FetchPokenameRu');

// offer filename to fetch data from
$source="https://ru.wikipedia.org/wiki/%D0%A1%D0%BF%D0%B8%D1%81%D0%BE%D0%BA_%D0%BF%D0%BE%D0%BA%D0%B5%D0%BC%D0%BE%D0%BD%D0%BE%D0%B2";


