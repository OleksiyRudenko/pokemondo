<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 26/07/2016
 * Time: 19:42
 */

if (array_keys(MODULE::$pathtree)[0]!=='public')
    print alert(
        'When ready, make "public" route first in app/config.modules.php.<br/>You can revert to these pages via /manage route.','warning');

include_once('app/class.dbTable.php');
include_once('app/dbSpec/db.tables.php');
$status = [
    strong('Following TABLES do not exist:')
];
$ok=true;
foreach ($DBT as $tbname=>$spec) {
    if (!sqlTableExists($tbname)) {
        $status[] = $tbname;
        $ok=false;
    }
}
if (!$ok) {
    $status[] = strong('Please, enter relevant management sections to complete the database.');
    echo alert(implode('<br/>',$status));
}

?>
