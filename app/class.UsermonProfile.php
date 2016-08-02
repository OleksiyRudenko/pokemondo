<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 02/08/2016
 * Time: 13:06
 */

class UsermonProfile {
    public static $path = [
        'useravabase'       =>  'img/user/ava/',    // id.jpg - user avatar
        'userprofilebase'   =>  'img/user/ava/',    // id.jpg - user result picture for og::
        'tplimg'            =>  'img/user/tpl-txt.png', // template
    ];

    private $u = [
        'id'            =>  0,
        'gender'        => 'x',
        'birthdate'     => '01/31/2000', // MM/DD/YYYY
    ];

    function __construct($userid,$gender='',$birthdate='') {
        $this->u = is_array($userid)
            ? $userid
            : [
                'id'            =>  $userid,
                'gender'        =>  $gender,
                'birthdate'    =>  $birthdate,
              ];
    }


    function selectPokemons() {

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
}