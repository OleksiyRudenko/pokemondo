<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 18/07/2016
 * Time: 14:35
 */

// =================== Global Functions
require_once('app/fn.helper.php');
require_once('app/fn.html.php');
require_once('app/fn.bootstrap.php');
require_once('app/fn.log.php');

// =================== Basic Globals


// =================== Classes
// require_once('app/DateBiz/DateBiz.class.php');
require_once('app/class.ARGV.php');
ARGV::initialize();
require_once('app/class.MODULE.php');

// =================== Configs
require_once('app/config.db.php');
require_once('app/config.modules.php');

// =================== Intializations
$DBH = DBconnect($DBconfig);
// DateBizCache::initialize($DBH,'dateadjustment');

