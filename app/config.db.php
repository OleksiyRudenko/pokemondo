<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 26/07/2016
 * Time: 17:06
 */

$DBconfig = [
    'host'      =>  'localhost',
    'user'      =>  'root',
    'pwd'       =>  'usbw',
    'dbname'    =>  'pokedata',
    'port'      =>  3307,
];

function DBconnect($DBconfig) {
    $dbh = new mysqli($DBconfig['host'],$DBconfig['user'],$DBconfig['pwd'],$DBconfig['dbname'],$DBconfig['port']);
    if ($dbh->connect_errno) {
        // try creating db and reconnect
        logMessage('DBinit',"Failed to connect to MySQL: (" . $dbh->connect_errno . ") " . $dbh->connect_error
            .'<br/>Please, create database via admin panel','danger');
    } else {
        // logMessage('DBinit',"Connected to MySQL: " . var_export($dbh,true),'success');
    }
    return $dbh;
}