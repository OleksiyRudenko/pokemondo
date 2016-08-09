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
        'public' => [
            'umask' =>  UMASK_GUEST,
            'viewSchema'    =>  'viewPublic',
        ],
        'manage' =>   [
            'umask' =>  UMASK_ADMIN,
            'viewSchema'    =>  'viewPrivate',
            'child' =>  [
                'pokedex'           => 0,
                'fetch-genders'     => 0,
                'fetch-pokemons'    => 0,
                'fetch-runames'     => 0,
                'poketype-ru'       => 0,
    //            'import-imagery'    => 0,
    //            'view-DataBase'     => 0,
            ],
        ],
        'users'     =>  [
            'umask' =>  UMASK_ROOT,
            'viewSchema'    =>  'viewPrivate',
        ],
        // 'public'    =>  0,
        'profile'   =>  [
            'umask' =>  UMASK_REGISTERED,
            'viewSchema'    =>  'viewPublic',
        ],
        'legal'     =>  [
            'umask' =>  UMASK_GUEST,
            'viewSchema'    =>  'viewPublic',
            'child' =>  [
                'privacy-policy'    => 0,
                'terms-of-service'        => 0,
            ],
        ],
];

// MODULE::$settings
// ModuleName.onSubmit.php is loaded if onSubmit property is set and $_POST['action']==any of action list
// ModuleName.preHTML.php is loaded if preHTML property is set
$settings = [
        'manage'        =>  [
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
            'navmenu'   => 'Manage poketypes',
            'heading'   => 'Manage Pokemon Types',
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
            'heading'   => 'Какой ты покемон?',
            'preHTML'   => true,
        ],
        'profile'          =>  [
            'basepath'  => 'Profile/Profile',
            'navmenu'   => 'User Profile',
            'heading'   => 'Какой ты покемон?',
            'onSubmit'  =>  ['Process'],
        ],
        'legal'          =>  [
            'basepath'  => 'Legal/Legal',
            'navmenu'   => 'Legal matters',
            'heading'   => 'Legal matters',
        ],
        'privacy-policy'  =>  [
            'basepath'  => 'Legal/PolicyPrivacy',
            'navmenu'   => 'Privacy Policy',
            'heading'   => 'Privacy Policy',
        ],
        'terms-of-service'  =>  [
            'basepath'  => 'Legal/TOS',
            'navmenu'   => 'Terms of Service',
            'heading'   => 'Terms of Service',
        ],

];

$viewSchema = [
    'viewPublic' => [
        'html.0head.php',
        'html.1body-public.php',
        'html.1body-xfinalize.html',
    ],
    'viewPrivate' => [
        'html.0head.php',
        'html.1body-private.php',
        'html.1body-xfinalize.html',
    ],
];

MODULE::initialize($pathtree,$settings,$viewSchema);