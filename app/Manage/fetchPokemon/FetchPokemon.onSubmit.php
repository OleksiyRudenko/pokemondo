<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 28/07/2016
 * Time: 21:33
 */

include_once('vendor/danrovito/pokephp/src/PokeApi.php');
use PokePHP\PokeApi; // https://github.com/danrovito/pokephp
$api = new PokeApi;

if (isset($_GET['action'])) {

    global $DBH, $DBT;
    include_once('app/class.dbTable.php');
    include_once('app/dbSpec/db.tables.php');
    $tbPokename = new dbTable($DBH,'pokename',$DBT['pokename']);
    $tbPoketype = new dbTable($DBH,'poketype',$DBT['poketype']);
    $tbPokedex = new dbTable($DBH,'pokedex',$DBT['pokedex']);

    switch ($_GET['action']) {
        case 'Fetch':
            if (!isset($_GET['pokeid'])) break;
            if (!isset($_GET['pokecount'])) $_GET['pokecount']=1;
            for ($pokecount=0;$pokecount<$_GET['pokecount'];$pokecount++) {
                // fetch pokemon: insert pokename, poketype; update pokedex
                $pokemona = json_decode($api->pokemon($_GET['pokeid']),true);
                unset($pokemona['stats']);
                unset($pokemona['abilities']);
                unset($pokemona['moves']);
                unset($pokemona['held_items']);
                unset($pokemona['game_indices']);
                $pokename = [
                    'pokeid'        => $pokemona['id'],
                    'pokename'      => $pokemona['name'],
                    'pokename_ru'   => '',
                    // 'sprites'   => $pokemona['sprites'],
                ];
                $poketype = [];
                foreach ($pokemona['types'] as $i=>$a)
                    $poketype[]=[$pokename['pokeid'],$a['type']['name']];

                // create records
                if ($tbPokename->insert($pokename)) {
                    if ($tbPoketype->insert($poketype)) {
                        // update pokedex
                        if (!$tbPokedex->update(['localdata'=>1],false,'pokeid='.$pokename['pokeid'])) {
                            logMessage('FetchPokemon','pokedex update: '.sqlError(),'danger');
                        }
                    } else {
                        logMessage('FetchPokemon','poketype: '.sqlError(),'danger');
                        $tbPokename->delete('pokeid='.$pokename['pokeid']);
                    }
                } else {
                    logMessage('FetchPokemon','pokename: '.sqlError(),'danger');
                }
                // log results
                foreach ($pokemona['types'] as $i=>$a)
                    $pokename['type'][]=$a['type']['name'];
                logMessage('FetchPokemon','Fetched: '.varExport($pokename));
                // next
                $_GET['pokeid']++;
            }
            break;
    }
}