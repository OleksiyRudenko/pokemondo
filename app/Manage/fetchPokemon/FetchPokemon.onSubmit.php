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
            logMessage('FetchPokemon','Fetched: '.varExport($pokename).varExport($poketype));

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

            /*
            $qr = $tbPokegender->select('pokeid',['prefix'=>'DISTINCT']);
            if ($qr && $qr->num_rows) {
                $row = $qr->fetch_all(MYSQLI_ASSOC);
                $qr->free();
                // prepare data add 4 zeros to denote we've got noting imported yet
                $merger = [0,0,0,0];
                foreach ($row as $n=>$rec)
                    $row[$n] = array_merge($rec,$merger);
                // insert
                if (!$qinsert = $tbPokedex->insert($row))
                    logMessage('Pokedex',sqlError(),'danger');
                logMessage('FetchPokemon','Table Populated','success');
            } else {
                logMessage('FetchPokemon',sqlError(),'danger');
            }
            // logMessage('FetchPokemon',varExport($row));
            */
            break;
    }
}