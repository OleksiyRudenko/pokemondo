<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 28/07/2016
 * Time: 21:31
 */
// ====================================================================

print '<div>USAGE: index.php?b=<i>starting_pokemon_id</i>&{e=<i>ending_pokemon_id</i>|l=<i>pokemon_count</i>}</div>';

if (!isset($_GET['b']))   $_GET['b']=1;
if (!isset($_GET['l']))  $_GET['l']=10;
if (!isset($_GET['e']))  $_GET['e']=$_GET['b']+$_GET['l'];
print '<pre>'.var_export($_GET,true).'</pre>';

$sprites = [
    'pokeapi' => [
        'front', 'front_shiny', 'front_female', 'front_shiny_female',
    ],
    'pokemondb' => [
        'normal', 'normal_anim', 'shiny', 'shiny_anim',
    ],
];

for ($i=$_GET['b'];$i<=$_GET['e'];$i++) {
    $pokemon = pokemon_profile(json_decode($api->pokemon($i)),$api);

    foreach ($sprites['pokeapi'] as $t)
        print '<img src="'.$pokemon['sprites']['pokeapi'][$t].'" />'."\n";
    foreach ($sprites['pokemondb'] as $t)
        print '<img src="'.$pokemon['sprites']['pokemondb'][$t].'" />'."\n";

    print '<pre>'.var_export($pokemon,true).'</pre>';
}

/**
 * @param $po Pokemon Object
 */
function pokemon_profile($po,&$api) {

    $namePokemondb = pokename_api2pokemondb($po->name);
    $pokemondbBaseUrl = 'https://img.pokemondb.net/sprites/black-white/';
    $types = [];
    foreach ($po->types as $to)
        $types[] = $to->type->name;
    $forms = [];
    foreach ($po->forms as $fo)
        $forms[] = $fo->name;
    $gender = pokegender_fromApi($po,$api);

    $profile = [
        'id'        => $po->id,
        'name'      => $po->name,
        'gender'    => $gender,
        'forms'     => $po->forms,
        'types'     => $types,
        'sprites'   => [
            'pokeapi' => [
                'front' => $po->sprites->front_default,
                'front_shiny' => $po->sprites->front_shiny,
                'front_female' => $po->sprites->front_female,
                'front_shiny_female' => $po->sprites->front_shiny_female,
            ],
            'pokemondb' => [
                // http://pokemondb.net/sprites/mr-mime
                //  https://img.pokemondb.net/sprites/black-white/normal/mr-mime.png
                //  https://img.pokemondb.net/sprites/black-white/anim/normal/mr-mime.gif
                //  https://img.pokemondb.net/sprites/black-white/shiny/mr-mime.png
                //  https://img.pokemondb.net/sprites/black-white/anim/shiny/mr-mime.gif
                'normal' => $pokemondbBaseUrl.'normal/'.$namePokemondb.'.png',
                'normal_anim' => $pokemondbBaseUrl.'anim/normal/'.$namePokemondb.'.gif',
                'shiny' => $pokemondbBaseUrl.'shiny/'.$namePokemondb.'.png',
                'shiny_anim' => $pokemondbBaseUrl.'anim/shiny/'.$namePokemondb.'.gif',
            ],
            /* 'bulbagarden' => [
                // http://bulbapedia.bulbagarden.net/wiki/List_of_Pok%C3%A9mon_by_name#M
                // http://bulbapedia.bulbagarden.net/wiki/File:122Mr._Mime.png
                //   http://cdn.bulbagarden.net/upload/e/ec/122Mr._Mime.png
                // http://bulbapedia.bulbagarden.net/wiki/File:131Lapras.png
                //   http://cdn.bulbagarden.net/upload/thumb/a/ab/131Lapras.png/240px-131Lapras.png
                // http://bulbapedia.bulbagarden.net/wiki/File:172Pichu.png
                //   http://cdn.bulbagarden.net/upload/thumb/b/b9/172Pichu.png/240px-172Pichu.png
                '240px' => 'http://cdn.bulbagarden.net/upload/thumb/b/b9/172Pichu.png/240px-172Pichu.png',
            ], */

        ],
    ];
    return $profile;
}


/**
 * @param $name - as supplied by pokeapi.co
 * @return string - as accepted by pokemondb.net img urls
 */
function pokename_api2pokemondb($name) {
    return $name;
}

function pokegender_fromApi(&$po,&$api) {
    $gender ='?';
    $name=$po->name;
    if ($name[strlen($name)-2]==='-')
        switch ($name[strlen($name)-1]) {
            case 'f': $gender='f'; break;
            case 'm': $gender='m'; break;
        }
    return $gender;
}
