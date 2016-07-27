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

function htmlElement($el,$inner='') {
    return '<'.$el.'>'.$inner.'</'.$el.">\n";
}