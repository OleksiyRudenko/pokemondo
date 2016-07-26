<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 26/07/2016
 * Time: 17:09
 */

function &explode_notnull($delim,$input)
// explodes $input array and returns array with !NULL values only
{
    $ret=array();
    if (is_array($delim))
    {
        $input=str_replace($delim,$delim[0],$input);
        $delim=$delim[0];
    }
    $src=explode($delim,$input);
    foreach ($src as $v) if ($v!=='') $ret[]=$v;
    return $ret;
}

function is_obj( &$object, $check=null, $strict=true )
{
    if( $check == null && is_object($object) )
    {
        return true;
    }
    if( is_object($object) )
    {
        $object_name = get_class($object);
        if( $strict === true )
        {
            if( $object_name == $check )
            {
                return true;
            }
        }
        else
        {
            if( strtolower($object_name) == strtolower($check) )
            {
                return true;
            }
        }
    }
}