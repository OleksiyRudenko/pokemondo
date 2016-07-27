<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 26/07/2016
 * Time: 17:08
 */

function alert($msg,$type='danger') { // success, info, warning, danger
    return '<div class="alert alert-'.$type.'" role="alert">'.$msg.'</div>';
}

function varExport(&$v,$name=false) {
    return alert(($name?'<strong>'.$name.'</strong> =<br/>':'').pre(var_export($v,true)),'info');
}

function ahref($url,$view) {
    return htmlElement('a',$view,['href'=>$url]);
}

/**
 * @param $name  : NAME = '$name'; doesn't override $attr['name']
 * @param $value : VALUE = '$value'
 * @param $view  : =$value if not set
 * @param string $style : default|primary|success|info|warning|danger|link
 * @param string $size : lg|md|sm|xs
 * @param $attr
 * @return string
 */
function button($name, $value, $view='', $style="primary", $size="lg", $attr=[]) {
    if ($name && !isset($attr['name']))     $attr['name']=$name;
    if ($value && !isset($attr['value']))   $attr['value']=$value;
    if (!$view)                             $view=$attr['value'];
    if (!isset($attr['type']))              $attr['type']='BUTTON';
    $attr['class'][] = 'btn';
    if ($style) $attr['class'][] = 'btn-'.$style;
    if ($size)  $attr['class'][] = 'btn-'.$size;
    $attr['class'] = implode(' ',$attr['class']);
    return htmlElement('button',$view,$attr);
}

/**
 * @param string $value
 * @param string $view
 * @param string $style
 * @param string $size
 * @param array $attr
 * @return string
 */
function buttonSubmit($value='submit', $view='Submit', $style="primary", $size="lg", $attr=[]) {
    $attr['type'] = 'SUBMIT';
    return button('action',$value,$view,$style,$size,$attr);
}