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
    'pokename'=> [ 'url'=>MODULE::getSetting('url','fetch-pokemons'),
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

if ($dbtbDependeciesExist) {

    if (!isset($_GET['pokecount']))
        $_GET['pokecount']=50;
    ?>
    <hr>
    <form method="GET">
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Fetch pokemon with id:</span>
                <input type="number" class="form-control"
                       id="pokeid" name="pokeid" aria-describedby="basic-addon1"
                       value="<?=$_GET['pokeid']?>">
                <span class="input-group-addon" id="basic-addon2">Count:</span>
                <input type="number" class="form-control"
                       id="pokecount" name="pokecount" aria-describedby="basic-addon2"
                       value="<?=$_GET['pokecount']?>">
            </div>
        </div>
        <div class="form-group">
            <?=buttonSubmit('Fetch','Fetch')?>
        </div>
    </form>
    <?php
}

print unlogMessage('DBH');
print unlogMessage('FetchPokenameRu');