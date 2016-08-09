<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 18/07/2016
 * Time: 14:35
 */

// =================== Global Functions
require_once('app/fn.helper.php');
require_once('app/fn.clisrv.php');
require_once('app/fn.html.php');
require_once('app/fn.bootstrap.php');
require_once('app/fn.log.php');
require_once('app/fn.sql.php');

/* logMessage('CORE','SCRIPT_URI: '.varExport($_SERVER['SCRIPT_URI']));
logMessage('CORE','REQUEST_URI: '.varExport($_SERVER['REQUEST_URI']));
logMessage('CORE','SCRIPT_FILENAME: '.varExport($_SERVER['SCRIPT_FILENAME'])); */

// =================== Basic Globals


// =================== Classes
// require_once('app/DateBiz/DateBiz.class.php');
require_once('app/class.USER.php');
require_once('app/class.ARGV.php');
ARGV::initialize();
logMessage('CORE','ARGV: '.varExport(ARGV::$a));
require_once('app/class.MODULE.php');

// =================== Configs
require_once('app/config.db.php');
require_once('app/config.modules.php');

// =================== Intializations
$DBH = DBconnect($DBconfig);
// DateBizCache::initialize($DBH,'dateadjustment');

