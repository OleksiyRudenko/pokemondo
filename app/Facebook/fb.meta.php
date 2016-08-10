<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 10/08/2016
 * Time: 20:11
 *
 * Publishes FB specific og meta headers.
 * See _src/fb-share.md for more details.
 */

$fbmetacollection = [
    'public'    =>  [
        'image'         =>  '/img/what-pokemon-are-you.jpg',
        'description'   =>  'Узнай какой ты покемон. Мы предложим тебе варианты подходящих типов покемонов согласно твоей покестихии.',
        'url'           =>  '/',
        'title'         =>  'Тест: какой ты покемон?',
    ],
    'outcome'    =>  [
        'image'         =>  '',
        'description'   =>  'А какой покемон - ты? Мы предложим тебе варианты подходящих типов покемонов согласно твоей покестихии.',
        'url'           =>  '/outcome/',
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
                $content = '/...';
            }
            $content = getFullServerName().$content;
            break;
        case 'url':
            if (MODULE::$currMod=='outcome') {
                // add arguments
                if (count(ARGV::$a))
                    $content .= implode('/',ARGV::$a);
            }
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