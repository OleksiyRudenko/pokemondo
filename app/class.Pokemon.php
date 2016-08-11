<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 28/07/2016
 * Time: 12:25
 */

class Pokemon {
    public $p; // properties
    /*
     * if loadPokemon() then:
     * pokeid
     * pokename
     * pokename_ru
     * poketype =>
     *      'poketype' => [ poketype=>'', poketype_ru=>'', poketypeclass=>'' ]
     */

    public static $poketypeclass = [
        'element'   =>  'Стихия',   // 9
        'origin'    =>  'Тип',      // 4
        'quality'   =>  'Качество', // 5
    ];

    public static $img = [
        'local'    => [
            'avatar' => [
                'static' => [
                    'normal'    => [
                        'urlbase'   =>  '/img/pokemon/avatar/static/normal/',
                        'filebase'   =>  'img/pokemon/avatar/static/normal/',
                        'id'        => 'pokeid000',
                        'type'      =>  '.png',
                    ],
                    'shiny'    => [ // same
                        'urlbase'   =>  '/img/pokemon/avatar/static/normal/',
                        'id'        => 'pokeid000',
                        'type'      =>  '.png',
                    ],
                ],
            ],
            'sprite' => [
                'anim' => [
                    'normal'   =>  [
                        'urlbase'   => '/img/pokemon/sprite/anim/normal/',
                        'id'        => 'pokename',
                        'type'      =>  '.gif'
                    ],
                    'shiny'   =>  [
                        'urlbase'   => '/img/pokemon/sprite/anim/shiny/',
                        'id'        => 'pokename',
                        'type'      =>  '.gif'
                    ],
                ],
                'static' => [
                    'normal'   =>  [
                        'urlbase'   => '/img/pokemon/sprite/static/normal/',
                        'id'        => 'pokename',
                        'type'      =>  '.png',
                    ],
                    'shiny'   =>  [
                        'urlbase'   => '/img/pokemon/sprite/static/shiny/',
                        'id'        => 'pokename',
                        'type'      =>  '.png',
                    ],
                ],
            ],
        ],
        'bulbapedia'    => [
            'sprite' => [
                'anim' => [
                    'normal'   =>  [
                        'urlbase'   => 'https://img.pokemondb.net/sprites/black-white/anim/normal/',
                        'id'        => 'pokename',
                        'type'      =>  '.gif'
                    ],
                    'shiny'   =>  [
                        'urlbase'   => 'https://img.pokemondb.net/sprites/black-white/anim/shiny/',
                        'id'        => 'pokename',
                        'type'      =>  '.gif'
                    ],
                ],
                'static' => [
                    'normal'   =>  [
                        'urlbase'   => 'https://img.pokemondb.net/sprites/black-white/normal/',
                        'id'        => 'pokename',
                        'type'      =>  '.png',
                    ],
                    'shiny'   =>  [
                        'urlbase'   => 'https://img.pokemondb.net/sprites/black-white/shiny/',
                        'id'        => 'pokename',
                        'type'      =>  '.png',
                    ],
                ],
            ],
        ],
        'pokemonCom'    => [
            'avatar' => [
                'static' => [
                    'normal'    => [
                        'urlbase'   =>  'http://assets.pokemon.com/assets/cms2/img/pokedex/detail/',
                        'id'        => 'pokeid000',
                        'type'      =>  '.png',
                    ],
                    'shiny'    => [ // same
                        'urlbase'   =>  'http://assets.pokemon.com/assets/cms2/img/pokedex/detail/',
                        'id'        => 'pokeid000',
                        'type'      =>  '.png',
                    ],
                ],
            ],
        ], // pokemonCom

        ];

    function __construct($p) {
        $this->p = is_scalar($p)
            ?self::loadPokemon($p)
            :$p;
        // make pokeid000
        $this->p['pokeid000'] = str_pad($this->p['pokeid'],3,'0',STR_PAD_LEFT);
    }

    /**
     * @param string|int $p : pokename or pokeid
     * @return array representing Pokemon
     */
    public static function loadPokemon($p) {
        global $DBH, $DBT;
        include_once('app/class.dbTable.php');
        include_once('app/dbSpec/db.tables.php');
        $tb = new dbTable($DBH,'pokename',$DBT['pokename']);
        $clauses = [
            'WHERE' => (is_numeric($p)
                ? 'pokename=\''.$p.'\''
                : 'pokeid='.$p),
        ];
        if ($qr=$tb->select('*',$clauses)) {
            if ($qr->num_rows) {
                $pokemon = $qr->fetch_assoc();
                $qr->free();
                // add types
                $tbtypes = new dbTable($DBH,'poketype',$DBT['poketype']);
                $clauses = [
                    'join' => ['LEFT JOIN','poketype_ru AS t2','ON t1.pokeid=t2.pokeid'],
                    'WHERE' => 't1.pokeid='.$pokemon['pokeid'],
                ];
                if ($qrtypes = $tbtypes->select('t2.*',$clauses)) {
                    while ($row=$qrtypes->fetch_assoc()) {
                        $pokemon['poketype'][$row['poketype']]=$row;
                    }
                } else {
                    logMessage('POKEMON',sqlError());
                }
                return $pokemon;
            } else {
                logMessage('POKEMON','No pokemon for "'.$p.'"');
            }
        } else {
            logMessage('POKEMON',sqlError());
        }
        return false;
    }

    function name($skipGender=true) {
        if ($skipGender) {
            $name = $this->p['pokename'];
            $i = strlen($name)-1;
            if ($name[$i-1]==='-' && $name[$i]=='f')
                return substr($name,0,-2);
        } else {
            return $this->p['pokename'];
        }
    }

    /**
     * @param $source : local|bulbapedia...
     * @param $class  : avatar|sprite
     * @param $type   : anim|static
     * @param $view   : normal|shiny
     */
    function imageUrl($source='bulbapedia', $class='sprite', $type='anim', $view='normal') {
        if (is_array($source)) {
            $class=$source[1];
            $type=$source[2];
            $view=$source[3];
            $source=$source[0];
        }
        $props = &self::$img[$source][$class][$type][$view];

        return $props['urlbase']
            .$this->p[$props['id']]
            .$props['type'];
    }

    function imageFileName($class='sprite', $type='anim', $view='normal') {
        $source = 'local';
        $props = &self::$img[$source][$class][$type][$view];

        return $props['filebase']
        .$this->p[$props['id']]
        .$props['type'];
    }

}