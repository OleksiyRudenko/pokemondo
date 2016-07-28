<p class="lead">Create and populate `pokename` and `poketype`. Update `pokedex`.</p>
<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 26/07/2016
 * Time: 21:14
 */

global $DBH, $DBT;
include_once('app/class.dbTable.php');
include_once('app/dbSpec/db.tables.php');

include_once('vendor/danrovito/pokephp/src/PokeApi.php');
use PokePHP\PokeApi; // https://github.com/danrovito/pokephp
$api = new PokeApi;

// check if dependecy tables exist
$dbTbDep = ['pokedex'=>0,];
$redirect = [
    'pokedex'=> [ 'url'=>MODULE::getSetting('url','pokedex'),
        'text' => 'create Pokedex', ],
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

// check if major table exists
$dbTbMain = ['pokename'=>0,'poketype'=>0,];
foreach (array_keys($dbTbMain) as $i=>$tbname) {
    $dbTbMain[$tbname] = new dbTable($DBH,$tbname,$DBT[$tbname]);
    if (!$dbTbMain[$tbname]->exists()) {
        $dbTbMain[$tbname]->create();
        print alert('Creating table `'.$tbname.'`.','info');
    }
}

foreach (array_keys($dbTbMain) as $i=>$tbname) {
    if (!$dbTbMain[$tbname]->exists()) {
        $dbtbMainExists = false;
        print alert('Table `'.$tbname.'` creation failed.','danger');
    }
}

print unlogMessage('FetchPokemon');

if ($dbtbDependeciesExist && $dbtbMainExists) {
    // we expect $_GET['pokeid']
    if (!isset($_GET['pokeid'])) {
        // show form
        ?>
        <form method="GET">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Pokemon id</span>
                <input type="text" class="form-control" id="pokeid" name="pokeid" aria-describedby="basic-addon1">
            </div>
        </form>
        <?php
    } else {
        // show pokemon data
        //!...
    }
}
