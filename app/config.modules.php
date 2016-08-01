<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 26/07/2016
 * Time: 17:38
 */

// MODULE::$pathtree
// NB! If a module refers to sub-modules, there is no way to access it via menu (unless it is first in the list)
$pathtree =    [
        // 'public' => 0,
        'manage-pokemons' =>   [
            'pokedex'           => 0,
            'fetch-genders'     => 0,
            'fetch-pokemons'    => 0,
            'fetch-runames'     => 0,
            'poketype-ru'       => 0,
//            'import-imagery'    => 0,
//            'view-DataBase'     => 0,
        ],
        'users' =>  0,
        'public' => 0,
];

// MODULE::$settings
// onSubmit is invoked if set and $_POST['action']==any of action list
$settings = [
        'manage-pokemons'        =>  [
            'basepath'  => 'Manage/Dashboard',
            'navmenu'   => 'Manage things',
            'heading'   => 'Manage Pokemon DB',
        ],
        'pokedex'  => [
            'basepath'  => 'Manage/Pokedex/Pokedex',
            'navmenu'   => 'Manage Pokedex',
            'heading'   => 'Manage Pokedex',
            'onSubmit'  =>  ['Build','Grab'],
        ],
        'fetch-genders'  => [
            'basepath'  => 'Manage/fetchGender/FetchGender',
            'navmenu'   => 'Fetch Gender Data',
            'heading'   => 'Fetch Pokemon Gender Data',
        ],
        'fetch-pokemons'  => [
            'basepath'  => 'Manage/fetchPokemon/FetchPokemon',
            'navmenu'   => 'Fetch Pokemon Data',
            'heading'   => 'Fetch Pokemon Profiles Data',
            'onSubmit'  =>  ['Fetch'],
        ],
        'fetch-runames'   => [
            'basepath'  => 'Manage/fetchPokenamesRu/FetchPokenamesRu',
            'navmenu'   => 'Add pokenames [ru]',
            'heading'   => 'Add Pokemon Names in Russian',
            'onSubmit'  =>  ['Fetch'],
        ],
        'poketype-ru'   => [
            'basepath'  => 'Manage/PoketypeRu/PoketypeRu',
            'navmenu'   => 'Translate poketypes [ru]',
            'heading'   => 'Add Pokemon Types in Russian',
            'onSubmit'  =>  ['Update'],
        ],
/*        'import-imagery' => [
            'basepath'  => 'Manage/importImagery/ImportImagery',
            'navmenu'   => 'Import Imagery',
            'heading'   => 'Import Pokemon Imagery Locally',
        ],
        'view-DataBase'  => [
            'basepath'  => 'Manage/viewDB/ViewDB',
            'navmenu'   => 'View Pokemons',
            'heading'   => 'View Pokemon Data From DB',
        ], */
        'users'         =>  [
            'basepath'  => 'Users/Users',
            'navmenu'   => 'Users',
            'heading'   => 'Users Dashboard',
        ],
        'public'          =>  [
            'basepath'  => 'Public/Public',
            'navmenu'   => 'Main job',
            'heading'   => 'Какой ты покемон',
        ],
];

MODULE::initialize($pathtree,$settings);