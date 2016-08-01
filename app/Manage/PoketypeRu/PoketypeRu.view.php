<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 01/08/2016
 * Time: 15:49
 */

global $DBH, $DBT;
include_once('app/class.dbTable.php');
include_once('app/dbSpec/db.tables.php');

// check if dependecy tables exist
$dbTbDep = ['poketype'=>0,];
$redirect = [
    'pokedex'=> [ 'url'=>MODULE::getSetting('url','pokedex'),
        'text' => 'create Pokedex', ],
];
$dbtbDependeciesExist = true;
foreach (array_keys($dbTbDep) as $i=> $tbname) {
    $dbTbDep[$tbname] = new dbTable($DBH,$tbname,$DBT[$tbname]);
    if (!$dbTbDep[$tbname]->exists()) {
        $dbtbDependeciesExist = false;
        print alert('Required table `'.$tbname.'` doesn\'t exist. Please, '
            .ahref($redirect[$tbname]['url'],$redirect[$tbname]['text']));
    }
}

// check if major table exists
$dbTbMain = ['poketype_ru'=>0,];
foreach (array_keys($dbTbMain) as $i=>$tbname) {
    $dbTbMain[$tbname] = new dbTable($DBH,$tbname,$DBT[$tbname]);
    if (!$dbTbMain[$tbname]->exists()) {
        $dbTbMain[$tbname]->create();
        print alert('Creating table `'.$tbname.'`.','info');
    }
}
$dbtbMainExists=true;
foreach (array_keys($dbTbMain) as $i=>$tbname) {
    if (!$dbTbMain[$tbname]->exists()) {
        $dbtbMainExists = false;
        print alert('Table `'.$tbname.'` creation failed.<br/>'.sqlError(),'danger');
    }
}
if ($dbtbDependeciesExist && $dbtbMainExists) {
    // populate poketype_ru from poketype
    $clauses = [
        'prefix'    => 'DISTINCT',
    ];
    $poketype = [];
    if ($qr=$dbTbDep['poketype']->select('poketype',$clauses)) {
        while ($row=$qr->fetch_assoc()) {
            $qr2 = $dbTbMain['poketype_ru']->select('poketype',['WHERE poketype=\''.$row['poketype'].'\'']);
            if (!$qr2 || $qr2->num_rows==0) {
                $poketype[]=[$row['poketype'],''];
            }
        }
        $qr->free();
        if (!$dbTbMain['poketype_ru']->insert($poketype)) {
            logMessage('PoketypeRu',sqlError(),'danger');
        }
    } else {
        logMessage('PoketypeRu',sqlError(),'danger');
    }

    unlogMessage('PoketypeRu');

    // get all `poketype_ru`; allow editing poketype_ru
    $clauses=[
        'ORDER BY'=>'poketype',
    ];
    $submit='<div class="form-group col-xs-12">'
        .buttonSubmit('Update','Update translations','primary','lg',['class'=>['pull-right']])
        .'</div>';
    if ($qr=$dbTbMain['poketype_ru']->select('*',$clauses)) {
        ?>
        <form method="POST"><table class="table table-hover table-responsive"><thead><tr><th>poketype</th><th>poketype_ru</th></tr></thead><tbody>
        <?php
        print $submit;
        $tr=[];
        while ($row=$qr->fetch_assoc()) {
            $tr[]=tr([
                $row['poketype'],
                '<INPUT class="form-control" TYPE="TEXT" NAME="poketype_ru['.$row['poketype'].']" VALUE="'.$row['poketype_ru'].'" />'
            ]);
        }
        print implode("\n",$tr);
        ?></tbody></table>
        <?=$submit?>
        </form>
        <?php

    } else {
        logMessage('PoketypeRu',sqlError(),'danger');
    }


    unlogMessage('PoketypeRu');



}
