<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 27/07/2016
 * Time: 15:54
 */

if (isset($_POST['action'])) {

    global $DBH, $DBT;
    include_once('app/class.dbTable.php');
    include_once('app/dbSpec/db.tables.php');
    include_once('app/class.Pokemon.php');

    $tbPokegender = new dbTable($DBH,'pokegender',$DBT['pokegender']);
    $tbPokedex = new dbTable($DBH,'pokedex',$DBT['pokedex']);

    switch ($_POST['action']) {
        case 'Build':
            $tbPokedex->drop(true); // if exists
            $tbPokedex->create();
            // get pokeids
            $qr = $tbPokegender->select('pokeid',['prefix'=>'DISTINCT']);
            if ($qr && $qr->num_rows) {
                $row = $qr->fetch_all(MYSQLI_ASSOC);
                $qr->free();
                // prepare data add 4 zeros to denote we've got nothing imported yet
                $merger = [0,0,0,0];
                foreach ($row as $n=>$rec)
                    $row[$n] = array_merge($rec,$merger);
                // insert
                if (!$qinsert = $tbPokedex->insert($row))
                    logMessage('Pokedex',sqlError(),'danger');
                logMessage('Pokedex','Table Populated','success');
            } else {
                logMessage('Pokedex',sqlError(),'danger');
            }
            // logMessage('Pokedex',varExport($row));
            break;
        case 'Grab':
            if (isset($_POST['getAvaRemote'])) {
                foreach ($_POST['getAvaRemote'] as $pokeid=>$val) {
                    $clauses = [
                        'WHERE'=>'pokeid='.$pokeid,
                    ];
                    if ($row=$tbPokedex->select('*',$clauses)) {
                        $data = $row->fetch_assoc();
                        $poke = new Pokemon($data);
                        $view = 'normal';
                        $remoteUrl = $poke->imageUrl('pokemonCom','avatar','static',$view);
                        $localFile = $poke->imageFileName('avatar','static',$view);
                        logMessage('Pokedex','Pokeid('.$pokeid.').grab '.$remoteUrl.' &gt; '.$localFile);
                        $row->free();
                        // TODO: Implement $remoteUrl > $localFile

                    } else {
                        logMessage('Pokedex',sqlError(),'danger');
                    }

                }
            }
            break;
    }
}
