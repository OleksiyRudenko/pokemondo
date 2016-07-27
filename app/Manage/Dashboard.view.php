<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 26/07/2016
 * Time: 19:42
 */

print
    alert(
        'When ready make "public" route first in app/config.modules.php.<br/>You can revert to these pages via /manage route.','warning');

print alert(
    'Enter every module under Manage things to populate database.','warning'
);
?>
<h2>Database Status</h2>
<?php
    include_once('app/class.dbTable.php');
    include_once('app/dbSpec/db.tables.php');
    $status = [
        strong('DB TABLES status:')
    ];
    foreach ($DBT as $tbname=>$spec) {
        $status[] = $tbname.': '.(sqlTableExists($tbname)?'OK':'inexistent!');
    }
    echo alert(implode('<br/>',$status),'info');

?>
