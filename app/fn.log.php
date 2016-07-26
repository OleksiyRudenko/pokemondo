<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 26/07/2016
 * Time: 17:33
 */

$LOG=[];
function logMessage($module,$msg,$type='info') {
    global $LOG;
    $LOG[$module][$type][]=$msg;
}

function unlogMessage($module,$type=['danger','warning','success','info']) {
    global $LOG;
    if (!isset($LOG[$module])) return '';
    $pool=[];
    if (!is_array($type)) $type=[$type];
    foreach ($type as $t) {
        if (isset($LOG[$module][$t])) {
            foreach ($LOG[$module][$t] as $msg) {
                $pool[]=alert('<strong>'.$module.'</strong>: '.$msg,$t);
                // echo alert($msg,$t);
            }
            unset($LOG[$module][$t]);
        }
    }
    // echo implode("\n",$pool);
    return implode("\n",$pool);
}