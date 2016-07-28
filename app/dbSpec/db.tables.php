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

    'pokedex'   => [
        'f'     => [
            'pokeid'        => 'SMALLINT UNSIGNED NOT NULL DEFAULT \'0\'',
            'localdata'     => 'TINYINT UNSIGNED NOT NULL DEFAULT \'0\'', // data imported from pokeapi.co
            'localsprite'   => 'TINYINT UNSIGNED NOT NULL DEFAULT \'0\'', // sprites imported from pokemondb.net/sprites/*
            'localani'      => 'TINYINT UNSIGNED NOT NULL DEFAULT \'0\'', // animated sprites imported from pokemondb.net/sprites/*
            'localimg'      => 'TINYINT UNSIGNED NOT NULL DEFAULT \'0\'', // bigger image imported from bulbapedia.
        ],
        'fx'    => [
            'UNIQUE (pokeid)',
        ]
    ], // pokedex

    'pokename'   => [
        'f'     => [
            'pokeid'        => 'SMALLINT UNSIGNED NOT NULL DEFAULT \'0\'',
            'pokename'      => 'VARCHAR(32) NOT NULL DEFAULT \'\'',
            'pokename_ru'   => 'VARCHAR(32) NOT NULL DEFAULT \'\'',
        ],
        'fx'    => [
            'UNIQUE (pokeid)',
        ]
    ], // pokename

    'poketype'   => [
        'f'     => [
            'pokeid'        => 'SMALLINT UNSIGNED NOT NULL DEFAULT \'0\'',
            'poketype'      => 'VARCHAR(32) NOT NULL DEFAULT \'\'',
        ],
        'fx'    => [
            'UNIQUE (pokeid,poketype)',
        ]
    ], // poketype



];