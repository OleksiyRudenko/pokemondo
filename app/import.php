<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 25/07/2016
 * Time: 19:03
 */

include_once('vendor/danrovito/pokephp/src/PokeApi.php');
use PokePHP\PokeApi; // https://github.com/danrovito/pokephp
$api = new PokeApi;

if (isset($_GET['b']) && isset($_GET['e']))
    for ($i=$_GET['b'];$i<=$_GET['b'];$i++) {
        $pokemon = json_decode($api->pokemon($i));
        print '<pre>'.var_export($pokemon,true).'</pre>';
    }
else
    print '<div>index.php?b=<i>n</i>&e=<i>m</i></div>';

phpinfo();
