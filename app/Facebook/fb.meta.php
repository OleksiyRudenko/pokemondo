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
        'image'         =>  '/img/what-pokemon-are-you.jpg',
        'description'   =>  'А какой покемон - ты? Мы предложим тебе варианты подходящих типов покемонов согласно твоей покестихии.',
        'url'           =>  '/outcome/',
        'title'         =>  'А какой покемон - ты?',
    ],


];

$result = [];

$fbmeta = &$fbmetacollection[isset($fbmetacollection[MODULE::$currMod])?MODULE::$currMod:'public'];

foreach ($fbmeta as $meta=>$content) {
    switch ($meta) {
        case 'image':
            // point to individual image if under 'outcome'
            if (MODULE::$currMod=='outcome' && UsermonProfile::$currentProfile) {
                $content = '/'.UsermonProfile::$currentProfile->getUserProfileImagename();
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
                $content = @UsermonProfile::$currentProfile->getProps()['name'].' - '
                    .@UsermonProfile::$currentProfile->currentPokemon->p['pokename_ru']
                    .'. '.$content;
            }
            break;
    }
    $result[]='<meta property="og:'.$meta.'" content="'.$content.'" />';
}

print implode("\n",$result);