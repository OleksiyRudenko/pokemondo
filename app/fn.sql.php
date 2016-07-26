<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 26/07/2016
 * Time: 21:17
 */


/**
 * @desc   Sanitizes string
 * @param  $data : String
 */
function sqlSanitizeStr($str) {
    global $DBH;
    return $DBH->escape_string($str);
}

/**
 * @desc   Sanitizes values in a record
 * @param  $data : Array [ field => value, ... ]
 */
function sqlSanitizeRecord(&$data) {
    global $DBH;
    foreach ($data as $field=>$value)
        $data[$field] = $DBH->escape_string($value);
}

/**
 * @desc   Sanitizes values in a set of records
 * @param  $data : Array [ 0 => [ field => value], 1 => ... ]
 */
function sqlSanitizeRecordSet(&$data) {
    global $DBH;
    foreach ($data as $i=>$record)
        sqlSanitizeRecord($data[$i]);
}