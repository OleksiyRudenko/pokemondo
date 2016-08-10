<p class="lead">Manage `unative`.</p>
<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 10/08/2016
 * Time: 18:06
 */

global $DBH, $DBT;
include_once('app/class.dbTable.php');
include_once('app/dbSpec/db.tables.php');
$tbUnative = new dbTable($DBH,'unative',$DBT['unative']);

$qr=$tbUnative->select();
