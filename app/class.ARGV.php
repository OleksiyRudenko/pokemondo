<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 26/07/2016
 * Time: 17:12
 */

class ARGV {
    public static $a;

    public static function initialize() {
        $uria =  explode('?',$_SERVER['REQUEST_URI']);
        self::$a=
            // array_slice(
            explode_notnull('/',$uria[0])
            //,2)
        ;
        // echo '<pre>'.var_export(self::$a,true).'</pre>';
    }
}