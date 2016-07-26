<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 26/07/2016
 * Time: 17:38
 */


$pathtree =    [   // MODULE::pathtree
        // 'public' => 0,
        'manage-pokemons' =>   [
            'fetch-genders'  => 0,
            'fetch-pokemons'  => 0,
            'bind-pokemon-gender'   => 0,
            'import-imagery' => 0,
            'view-DataBase'  => 0,
        ],
        'users' =>  0,
        'public' => 0,
];

$settings = [   // MODULE::$setting
        'manage-pokemons'        =>  [
            'basepath'  => 'Manage/Dashboard',
            'navmenu'   => 'Manage things',
            'heading'   => 'Manage Pokemon DB',
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
        ],
        'bind-pokemon-gender'   => [
            'basepath'  => 'Manage/bindPokeGen/BindPokeGen',
            'navmenu'   => 'Bind Gender Data',
            'heading'   => 'Bind Pokemon Data with Gender Data',
        ],
        'import-imagery' => [
            'basepath'  => 'Manage/importImagery/ImportImagery',
            'navmenu'   => 'Import Imagery',
            'heading'   => 'Import Pokemon Imagery Locally',
        ],
        'view-DataBase'  => [
            'basepath'  => 'Manage/viewDB/ViewDB',
            'navmenu'   => 'View Pokemons',
            'heading'   => 'View Pokemon Data From DB',
        ],
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