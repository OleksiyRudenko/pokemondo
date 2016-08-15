<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 26/07/2016
 * Time: 17:07
 */

function p($html) {
    return htmlElement('p',$html);
}

function div($html) {
    return htmlElement('div',$html);
}

function pre($html) {
    return htmlElement('pre',$html);
}

function strong($html) {
    return htmlElement('strong',$html);
}

/* function ahref($html,$href) {
    return htmlElement('a',$html,['href'=>$href]);
} */

/**
 * @param $el
 * @param string $inner
 * @param mixed $attr : [ attr=>value,...]
 * @return string
 */
function htmlElement($el, $inner='', $attr='') {
    if ($attr) {
        $alist=[];
        if (!is_array($attr))
            $attr=[$attr=>''];
        foreach ($attr as $a=>$v)
            $alist[]= $a.($v?'="'.$v.'"':'');
        $attr = (count($alist)?' ':'').implode(' ',$alist);
    }
    return '<'.$el.$attr.'>'.$inner.'</'.$el.">\n";
}

function htmlElementSingle($el, $attr='') {
    if ($attr) {
        $alist=[];
        if (!is_array($attr))
            $attr=[$attr=>''];
        foreach ($attr as $a=>$v)
            $alist[]= $a.($v?'="'.$v.'"':'');
        $attr = (count($alist)?' ':'').implode(' ',$alist);
    }
    return '<'.$el.$attr.' />'."\n";
}

function tr($tda) {
    return '<tr><td>'.implode('</td><td>',$tda).'</td></tr>';
}

function selectOptions($options,$selected='') {
    $opt = [];
    foreach ($options as $v=>$t) {
        $opt[] = '<option value="'.$v.'"'.($v==$selected?' SELECTED':'').'>'.$t.'</option>';
    }
    return implode("\n",$opt);
}