<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 26/07/2016
 * Time: 19:26
 */

// =================== Forced preHTML processing
if (MODULE::currSetting('preHTML'))
    MODULE::loadPreHTML();

// =================== User Form Submissions Processing
if (MODULE::currSetting('onSubmit'))
    foreach (MODULE::currSetting('onSubmit') as $action)
        if (@$_REQUEST['action']==$action) {
            MODULE::loadOnSubmit();
            break;
        }
