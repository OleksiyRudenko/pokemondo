<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 26/07/2016
 * Time: 21:35
 */

// ********* Tests Inclusion ****************
?>
<h2>Test sql.helpers</h2>
<h3>Initial</h3>
<?php
$string = "abc\n'\\";
$record = [
    'field1' => 'abcd',
    'field2' => "abc\n'\\",
];
$recordset = [
    [
      'field1' => 'abcd',
      'field2' => "abc\n'\\",
    ],
    [
        'field11' => 'ABCD',
        'field22' => "ABC\n'T\\",
    ],
];

echo varExport($string,'STRING');
echo varExport($record,'RECORD');
echo varExport($recordset,'RECORDSET');
?>
<h3>Sanitized</h3>
<?php

$string=sqlSanitizeStr($string);
sqlSanitizeRecord($record);
sqlSanitizeRecordSet($recordset);

echo varExport($string,'STRING');
echo varExport($record,'RECORD');
echo varExport($recordset,'RECORDSET');


