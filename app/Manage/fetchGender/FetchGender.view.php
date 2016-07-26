<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 26/07/2016
 * Time: 21:05
 */

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
print '<pre>'.var_export($gender,true).'</pre>';