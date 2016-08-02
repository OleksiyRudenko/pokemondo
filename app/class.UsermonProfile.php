<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 02/08/2016
 * Time: 13:06
 */

include_once('app/class.Pokemon.php');

class UsermonProfile {
    public static $path = [
        'useravabase'       =>  'img/user/ava/',    // id.jpg - user avatar
        'userprofilebase'   =>  'img/user/profile/',    // id.jpg - user result picture for og::
        'tplimg'            =>  'img/user/tpl-txt.png', // template
    ];

    public static $poketypeclassElement = [
        'dark', 'ice', 'grass', 'ground', 'steel', 'fire', 'rock', 'water', 'electric',
    ];

    public static $pokemonList = [];

    private $u = [
        'id'            =>  0,
        'gender'        => 'x',
        'name'          => '',
        'birthdate'     => '01/31/2000', // MM/DD/YYYY
    ];

    function __construct($userid,$username,$gender='',$birthdate='') {
        $this->u = is_array($userid)
            ? $userid
            : [
                'id'            =>  $userid,
                'name'          =>  $username,
                'gender'        =>  $gender,
                'birthdate'     =>  $birthdate,
              ];
    }


    /**
     * @desc   Gets pokemons that meet user criteria
     * @return array : [class.Pokemon,...]
     */
    function selectPokemons() {
        global $DBH, $DBT;
        $pokelist = [];
        // allowed genders
        $pokegender = ['x', 'n'];
        if ($this->u['gender']=='f' || $this->u['gender']=='m')
            $pokegender[]=$this->u['gender'];

        $poketype=$this->getElement();
        $tb = new dbTable($DBH,'poketype',$DBT['poketype']);
        $clauses = [
            'join'  => [
                'RIGHT JOIN pokegender AS t2 ON t2.pokeid=t1.pokeid',// AND t2.gender IN (\''.implode('\',\'',$pokegender).'\')',
                'LEFT JOIN pokename AS t3 ON t3.pokeid=t1.pokeid'
            ],
            'WHERE' => 't1.poketype=\''.$poketype.'\'',
            // 't1.pokegender in (\''.implode('\',\'',$pokegender).'\')',
        ];
        if ($qr=$tb->select('*',$clauses)) {
            while ($row=$qr->fetch_assoc()) {
                $pokelist[] = new Pokemon($row);
            }
        } else {
            logMessage('UsermonProfile','UsermonProfile::selectPokemons(): '.sqlError());
            return $pokelist;
        }
        return $pokelist;
    }

    function getElement() {
        $poketypeNr=0;
        if (strlen($this->u['birthdate'])>4) {
            $DOY=round((substr($this->u['birthdate'],0,2)-1)*30.4+substr($this->u['birthdate'],3,2));
            $poketypeNr=floor($DOY/46)+1;
        }
        return self::$poketypeclassElement[$poketypeNr];
    }

    /*
     * Pokemon local ava dims:
     *   215x215
     * FB user avatar dims:
     *   http://graph.facebook.com/67563683055/picture?type=
     *      square   50 x  50
     *      small    50 x  50
     *      normal  100 x 100
     *      large   200 x 200
     * Normal og-image template dims:
     *   800x420
     *
     * Template presets:
     *  userAva-bgRect
     *      margins     8 8 8 3
     *      loc         90;48
     *      dims        216x211
     *  userAva
     *      loc         userAva-bgRect.loc +(8;8)
     *      dims        200x200
     *  userName-bgRect
     *      margins     8 3 8 8
     *      loc         userAva-bgRect.loc +(0;211) = (90;259)
     *      dims        216x43
     *  userName-printArea
     *      loc         userName-bgRect.loc +(8;3)
     *      dims        200x32
     *  pokeAva-bgCircle
     *      center      userAva.loc +(?;100)
     *      R           100
     *  pokeAva
     *      loc         (494;48)
     *      dims        215x215
     *  pokeName-bgRect
     *      margins     8 3 8 8
     *      loc         bgRect.loc +(0;211) = (494;259)
     *      dims        216x43
     *  pokeName-printArea
     *      loc         userName-bgRect.loc +(8;3)
     *      dims        200x32
     */
    function a() {

    }

    /**
     * @desc  Create profile image
     * @param $pokemon Pokemon
     */
    function createProfileImg($pokemon) {
        // load template
        $img = imagecreatefrompng(self::$path['tplimg']);
        // load user avatar
        $imgAva = imagecreatefromjpeg($this->getUserAvaFilename());
        // merge user avatar
        imagecopymerge($img,$imgAva,98,56,0,0,200,200,0);
        imagedestroy($imgAva);
        // load pokemon avatar
        $imgPoke = imagecreatefrompng($pokemon->imageFilename('avatar','static','normal'));
        // merge pokemon avatar
        imagecopymerge($img,$imgPoke,494,48,0,0,215,215,0);
        imagedestroy($imgPoke);


        // save $img
        imagealphablending($img, false);
        imagesavealpha($img, true);
        imagepng($img,$this->getUserProfileImagename(),9);
        // free resource
        imagedestroy($img);
    }

    function getUserAvaFilename() {
        return self::$path['useravabase'].$this->u['id'].'.jpg';
    }
    function getUserProfileImagename() {
        return self::$path['userprofilebase'].$this->u['id'].'.png';
    }
}