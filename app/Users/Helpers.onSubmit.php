<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 10/08/2016
 * Time: 17:58
 */
if (isset($_POST['action'])) {

    // global $DBH, $DBT;
    // include_once('app/class.dbTable.php');
    // include_once('app/dbSpec/db.tables.php');

    switch ($_POST['action']) {
        case 'md5':
            logMessage('HELPERS','md5='.md5(md5($_POST['usalt']).md5($_POST['pwd'])),'info');
            break;
    }
}
