<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 09/08/2016
 * Time: 11:32
 */
if (isset($_POST['action'])) {

    global $DBH, $DBT;
    include_once('app/class.dbTable.php');
    include_once('app/dbSpec/db.tables.php');

    switch ($_POST['action']) {
        case 'Login':
            if (!USER::login($_POST['login'],$_POST['password']))
                logMessage('AUTH','Bad login and/or password','danger');
            break;
    }
}
