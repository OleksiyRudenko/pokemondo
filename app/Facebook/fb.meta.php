<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 10/08/2016
 * Time: 20:11
 *
 * Publishes FB specific og meta headers
 */

$fbmetacollection = [
    'public'    =>  [
        'image'         =>  'img/what-pokemon-are-you.jpg',
        'description'   =>  'Узнай какой ты покемон. Мы предложим тебе варианты подходящих типов покемонов согласно твоей покестихии.',
        'url'           =>  '',
        'title'         =>  'Тест: какой ты покемон?',
    ],
    'outcome'    =>  [
        'image'         =>  '',
        'description'   =>  'А какой покемон - ты? Мы предложим тебе варианты подходящих типов покемонов согласно твоей покестихии.',
        'url'           =>  'outcome/',
        'title'         =>  'А какой покемон - ты?',
    ],


];

$result = [];

$fbmeta = &$fbmetacollection[MODULE::$currMod];
foreach ($fbmeta as $meta=>$content) {
    switch ($meta) {
        case 'image':
            // point to individual image if under 'outcome'
            if (MODULE::$currMod=='outcome') {
                //!...
                $content = '...';
            }
        case 'url':
            $content = getFullServerName().$content;
            break;
        case 'description':
        case 'title':
            if (MODULE::$currMod=='outcome') {
                // prepend content with individual prefix: "Name - Pokename"
                //!...
                $content = 'Name - Pokename. '.$content;
            }
            break;
    }
    $result[]='<meta property="og:'.$meta.'" content="'.$content.'" />';
}

print implode("\n",$result);