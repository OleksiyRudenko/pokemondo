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
        'tplimg'            =>  'img/user/tpl.jpg', // template
    ];

    private $u = [
        'id'            =>  0,
        'gender'        => 'x',
        'birthmonth'    =>  '1',
    ];

    function __construct($userid,$gender,$birthmonth) {
        $this->u = [
            'id'            =>  $userid,
            'gender'        =>  $gender,
            'birthmonth'    =>  $birthmonth,
        ];
    }
}