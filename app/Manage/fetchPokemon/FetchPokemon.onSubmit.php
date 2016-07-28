<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 28/07/2016
 * Time: 21:33
 */

if (isset($_GET['action'])) {

    global $DBH, $DBT;
    include_once('app/class.dbTable.php');
    include_once('app/dbSpec/db.tables.php');
    $tbPokename = new dbTable($DBH,'pokename',$DBT['pokename']);
    $tbPoketype = new dbTable($DBH,'pokename',$DBT['poketype']);
    $tbPokedex = new dbTable($DBH,'pokedex',$DBT['pokedex']);

    switch ($_POST['action']) {
        case 'Fetch':
            // fetch pokemon: insert pokename, poketype; update pokedex
            $pokemon = json_decode($api->pokemon($_GET['pokeid']));
            logMessage('FetchPokemon',varExport($pokemon));
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