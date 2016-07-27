<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 26/07/2016
 * Time: 21:05
 */

include_once('app/class.dbTable.php');
include_once('app/dbSpec/db.tables.php');

if (sqlTableExists('pokegender')) {
    // show pokegender data

} else {
    // populate pokegender from pokeapi.co

    include_once('vendor/danrovito/pokephp/src/PokeApi.php');
    use PokePHP\PokeApi; // https://github.com/danrovito/pokephp
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
    echo varExport($glist);
}
