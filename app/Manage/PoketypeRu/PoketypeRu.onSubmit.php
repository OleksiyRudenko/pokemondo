<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 01/08/2016
 * Time: 17:01
 */

if (isset($_POST['action'])) {

    global $DBH, $DBT;
    include_once('app/class.dbTable.php');
    include_once('app/dbSpec/db.tables.php');

    $tbPoketypeRu = new dbTable($DBH, 'poketype_ru', $DBT['poketype_ru']);

    switch ($_POST['action']) {
        case 'Update':
            foreach ($_POST['poketype_ru'] as $poketype=>$poketypeRu) {
                if (strlen($poketypeRu)) {
                    if (!$tbPoketypeRu->update(
                        [
                            'poketype_ru'=>$poketypeRu,
                            'poketypeclass'=>$_POST['poketypeclass'][$poketype],
                        ],
                        false,'poketype=\''.$poketype.'\''))
                        logMessage('PoketypeRu',sqlError(),'danger');
                }
            }
            break;
    }
}
