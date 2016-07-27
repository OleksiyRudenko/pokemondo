<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 27/07/2016
 * Time: 10:41
 */

/*
[
    tablename => [ f=>[field-name=>field-spec,...],
                    fx=>[optional-key=>constraint|index-spec,...],
                   ]
]
*/

$DBT = [
    'pokegender' => [
        'f'     =>  [   // field list
            'pokeid'    => 'SMALLINT UNSIGNED NOT NULL DEFAULT \'0\'',
            'gender'    => 'CHAR(1) NOT NULL DEFAULT \'n\'',
        ],
        'fx'    =>  [   // not fields but exist in context of fieldlist; if index is numeric then ignored on creation stage
            'UNIQUE (pokeid,gender)',
        ],
    ], // pokegender

];