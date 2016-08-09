<?php
include_once('app/init.php');
include_once('app/preHTML.php');
MODULE::showView();
/*include_once('html.0head.php');
include_once( MODULE::$currMod == 'public'
    ? 'html.1body-public.php'
    : 'html.1body-private.php'
);
include_once('html.1body-xfinalize.html'); */
include_once('app/postHTML.php');