<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 29/07/2016
 * Time: 17:06
 */

/**
 * @param $url
 * @return array : [error=>false|'errorMessage', data=>mixed...]
 */
function curlGet($url) {
    //return $uri;
    $ch = curl_init();

    $timeout = 5;

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);

    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    $curl_errno = curl_errno($ch);
    $curl_error = curl_error($ch);

    curl_close($ch);

    if ($http_code != 200) {
        return ['error'=>'An error '.$http_code.' has occured. curl ('.$curl_errno.') '.$curl_error];
    }

    return ['error'=>false,'data'=>$data];
}