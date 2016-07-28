<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 27/07/2016
 * Time: 18:23
 */

global $DBH, $DBT;
include_once('app/class.dbTable.php');
include_once('app/dbSpec/db.tables.php');
include_once('app/class.Pokemon.php');
// $tbPokegender = new dbTable($DBH,'pokegender',$DBT['pokegender']);
$tbPokedex = new dbTable($DBH,'pokedex',$DBT['pokedex']);

if (($reccount=$tbPokedex->countRows('pokeid'))==0) {
    alert('Database is empty');
} else {
    if (!isset($_GET['pg'])) $_GET['pg']=1;
    $limit = 10;
    $page = $_GET['pg'];
    $pages = ceil($reccount/$limit);
    if ($page<1) $page = 1;
    if ($page>$pages) $page=$pages;


    // inquire table
    $clauses = [
        'join'      => 'JOIN pokename AS t2 ON t1.pokeid=t2.pokeid',
        'ORDER BY'  => 't1.pokeid',
        'LIMIT'     => (($page-1) * $limit).','.$limit,
    ];
    if (!$qr = $tbPokedex->select('*',$clauses))
        logMessage('Pokedex',sqlError());

    print unlogMessage('DBH');
    print unlogMessage('Pokedex');

    // show data
    $paginator=paginator('Browse data',$page,$pages);
    print $paginator;
    $headers = ['pokeid','data','local sprite','remote sprite','local anim','remote anim','local ava','remote ava'];
    print '<table class="table table-hover table-responsive"><thead><tr><td>'
        . tr($headers)
        .'</td></tr></thead><tbody>';
    $view='shiny';
    while ($row=$qr->fetch_assoc()) {
        $poke=new Pokemon($row);
        $tr=[];
        $tr[]=$row['pokeid'];
        $tr[]=$row['localdata'];
        $localdata = $row['localdata'];
        $tr[]=$row['localsprite'].($localdata?$poke->imageUrl('local','sprite','static',$view):'');
        $tr[]=$poke->imageUrl('bulbapedia','sprite','static',$view);
        $tr[]=$row['localani'].($localdata?$poke->imageUrl('local','sprite','anim',$view):'');
        $tr[]=$poke->imageUrl('bulbapedia','sprite','anim',$view);
        $tr[]=$row['localimg'].($localdata?$poke->imageUrl('local','avatar','static',$view):'');
        $tr[]='No source for avatar';// $poke->imageUrl('bulbapedia','avatar','static',$view);
        print tr($tr);
    }
    print '</tbody></table>'.$paginator;


}


/*
print paginator('Browse pokedex',1,26);
print paginator('Browse pokedex',5,26);
print paginator('Browse pokedex',9,26);
print paginator('Browse pokedex',14,26);
print paginator('Browse pokedex',24,26);
print paginator('Browse pokedex',25,26);
print paginator('Browse pokedex',26,26);
print paginator('Browse pokedex',28,26);
print paginator('Browse pokedex',101,300);
print paginator('Browse pokedex',542,900);
print paginator('Browse pokedex',542,1000);
print paginator('Browse pokedex',542,1100);
print paginator('Browse pokedex',542,1200);
print paginator('Browse pokedex',5428,12000);
print paginator('Browse pokedex',54285,120000);
print paginator('Browse pokedex',542850,1200000); */