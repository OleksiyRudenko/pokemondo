<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 26/07/2016
 * Time: 19:26
 */

// =================== User Form Submissions Processing
if (MODULE::currSetting('onSubmit'))
    foreach (MODULE::currSetting('onSubmit') as $action)
        if ($_POST['action']==$action) {
            MODULE::loadOnSubmit();
            break;
        }
