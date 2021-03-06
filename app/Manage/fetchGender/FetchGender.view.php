<p class="lead">Create and populate `pokegender`.</p>
<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 26/07/2016
 * Time: 21:05
 */

global $DBH, $DBT;
include_once('app/class.dbTable.php');
include_once('app/dbSpec/db.tables.php');
$tbPokegender = new dbTable($DBH,'pokegender',$DBT['pokegender']);

include_once('vendor/danrovito/pokephp/src/PokeApi.php');
use PokePHP\PokeApi; // https://github.com/danrovito/pokephp

$populate=false;
// create if inexistent
if (!$tbPokegender->exists()) {
    $populate = true;
    $tbPokegender->create();
    print alert('Create TABLE pokegender','info');
} else {
    // check if there any data
    $qr = $tbPokegender->select('COUNT(pokeid) AS cnt');
    if (!$qr->fetch_assoc()['cnt']) {
        $populate = true;
    }
}

// populate if required
if ($populate) {
    print alert('Populate TABLE pokegender','info');
    pokegenderPopulate($tbPokegender);
}

// select data
$genderset = ['m','f','x','n'];

$col = [];
foreach ($genderset as $gender) {
    $clauses = [
        'WHERE'     => 'gender=\''.$gender.'\'',
        'ORDER BY'  => 'pokeid',
    ];
    $qr=$tbPokegender->select('*',$clauses);
    $recset = [ strong($gender).'('.$qr->num_rows.')' ];
    while ($row=$qr->fetch_assoc()) {
        $recset[] = 'gender='.$row['gender'].'; pokeid='.$row['pokeid'];
    }
    $qr->free();
    $col[$gender]=implode('<br/>',$recset);
}

// show data
print '<h2>Pokemons by gender</h2><table class="table table-condensed"><thead><tr>';
foreach ($genderset as $gender)
    print '<td>'.$gender.'</td>';
print '</tr></thead><tbody><tr><td>'.implode('</td><td>',$col).'</td></tr>';
print '</tbody></table>';


// =================================================================================================


function pokegenderPopulate($tbh) {
    // populate pokegender from pokeapi.co
    $api = new PokeApi;

    $genderlist = ['female','male','genderless'];
    $gender = [
        'female' => [],
        'male' => [],
        'genderless' => [],
    ];

    for ($i=0;$i<3;$i++) {
        // $i = 0;
        $gr = json_decode($api->gender($i+1),true);
        // print '<pre>'.var_export($gr,true).'</pre>';

        foreach ($gr['pokemon_species_details'] as $go) {
            $a = explode('/',$go['pokemon_species']['url']);
            // print '<pre>'.var_export($a,true).'</pre>';
            $id = $a[count($a)-2];
            $gender[$genderlist[$i]][$id] = $go['pokemon_species']['name'];
        }
    }
    // print '<pre>'.var_export($gender,true).'</pre>';

    // build gender lists: f - female only, m - male only, x - either, n - neither

    $glist = [
        'f' => [],
        'm' => [],
        'x' => [],
        'n' => [],
    ];

    foreach ($gender['female'] as $id=>$name)
            $glist[(isset($gender['male'][$id])?'x':'f')][$id] = $name;
    foreach ($gender['male'] as $id=>$name)
            $glist[(isset($gender['female'][$id])?'x':'m')][$id] = $name;
    foreach ($gender['genderless'] as $id=>$name)
        $glist['n'][$id] = $name;
    // echo varExport($glist);

    // prepare values
    foreach ($glist as $gender=>$pokemons) {
        $valueset = [];
        foreach ($pokemons as $id=>$name)
            $valueset[] = [$id,$gender];
        $qr=$tbh->insert($valueset);
        $qr->free();
    }

    print alert('TABLE pokegender populated','success');
}
