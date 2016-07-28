<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 28/07/2016
 * Time: 12:25
 */

class Pokemon {
    public $p; // properties

    public static $img = [
        'local'    => [
            'avatar' => [
                'static' => [
                    'normal'    => [
                        'urlbase'   =>  '/img/pokemon/avatar/static/normal/',
                        'type'      =>  '.png',
                    ],
                ],
            ],
            'sprite' => [
                'anim' => [
                    'normal'   =>  [
                        'urlbase'   => '/img/pokemon/sprite/anim/normal/',
                        'type'      =>  '.gif'
                    ],
                    'shiny'   =>  [
                        'urlbase'   => '/img/pokemon/sprite/anim/shiny/',
                        'type'      =>  '.gif'
                    ],
                ],
                'static' => [
                    'normal'   =>  [
                        'urlbase'   => '/img/pokemon/sprite/static/normal/',
                        'type'      =>  '.png',
                    ],
                    'shiny'   =>  [
                        'urlbase'   => '/img/pokemon/sprite/static/shiny/',
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
                        'type'      =>  '.gif'
                    ],
                    'shiny'   =>  [
                        'urlbase'   => 'https://img.pokemondb.net/sprites/black-white/anim/shiny/',
                        'type'      =>  '.gif'
                    ],
                ],
                'static' => [
                    'normal'   =>  [
                        'urlbase'   => 'https://img.pokemondb.net/sprites/black-white/normal/',
                        'type'      =>  '.png',
                    ],
                    'shiny'   =>  [
                        'urlbase'   => 'https://img.pokemondb.net/sprites/black-white/shiny/',
                        'type'      =>  '.png',
                    ],
                ],
            ],
        ],
    ];

    function __construct($p) {
        $this->p = $p;
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
    function imageUrl($source='bulbapedia', $class='sprite', $type='anim', $view='shiny') {
        if (is_array($source)) {
            $class=$source[1];
            $type=$source[2];
            $view=$source[3];
            $source=$source[0];
        }
        return self::$img[$source][$class][$type][$view]['urlbase']
            .$this->p['pokename']
            .self::$img[$source][$class][$type][$view]['type'];
    }
}