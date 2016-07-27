<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 27/07/2016
 * Time: 10:41
 */

$DBT = [
    'pokegender' => [
        'f'     =>  [   // field list
            'gender'    => 'CHAR(1) NOT NULL DEFAULT \'n\'',
            'pokeid'    => 'SMALLINT UNSIGNED NOT NULL DEFAULT \'0\'',
        ],
        'fx'    =>  [   // not fields but exist in context of fieldlist; if index is numeric then ignored on creation stage
            'UNIQUE (gender,pokeid)',
        ],
    ], // pokegender

];