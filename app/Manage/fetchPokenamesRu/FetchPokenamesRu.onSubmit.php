<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 29/07/2016
 * Time: 18:21
 */

if (isset($_GET['action'])) {

    global $DBH, $DBT;
    include_once('app/class.dbTable.php');
    include_once('app/dbSpec/db.tables.php');
    include_once('app/fn.file.php');

    $tbPokename = new dbTable($DBH,'pokename',$DBT['pokename']);

    switch ($_GET['action']) {
        case 'Fetch':
            if (!isset($_GET['pokeid'])) break;
            if (!isset($_GET['pokecount'])) $_GET['pokecount']=1;

            // resource filename to fetch data from
            $source = "https://ru.wikipedia.org/wiki/%D0%A1%D0%BF%D0%B8%D1%81%D0%BE%D0%BA_%D0%BF%D0%BE%D0%BA%D0%B5%D0%BC%D0%BE%D0%BD%D0%BE%D0%B2";

            $qr = curlGet($source);
            if ($qr['error']) {
                logMessage('FetchPokenameRu',alert('<div>' . $qr['error'] . '</div>'));
            } else {
                logMessage('FetchPokenameRu','Data fetched from '.$source,'success');
                // print alert('Data fetched', 'success');
                $data = &$qr['data'];
                // print $data;
                // extract tables
                $matches = [];
                // preg_match_all("|<table class=\"wikitable\" border=\"1\">.+</table>|U",$data,$table);
                preg_match_all("|<table class=\"wikitable\" border=\"1\">.+<\/table>|sU", $data, $matches);

                $table = $matches[0];

                //print varExport($table);

                /* $tmp = [];
                foreach ($table as $i=>$a)
                    if (is_array($a)) {
                        foreach ($a as $j=>$b)
                            $tmp[$i][$j]=htmlentities($b);
                    } else {
                        $tmp[$i]=htmlentities($a);
                    }

                print varExport($tmp); */

                // parse out id, name_en, name_ru
                /*
                 * <tr>
                    <td>001</td>
                    <td>フシギダネ</td>
                    <td>Fushigidane</td>
                    <td>Фусигиданэ</td>
                    <td>Bulbasaur</td>
                    <td><a href="/wiki/%D0%91%D1%83%D0%BB%D1%8C%D0%B1%D0%B0%D0%B7%D0%B0%D0%B2%D1%80" title="Бульбазавр">Бульбазавр</a></td>
                 */
                $name_ru=[];
                // logMessage('FetchPokenameRu',count($table));
                for ($i = 0; $i < 6; $i++) { // table[6] contains something strange
                    // logMessage('FetchPokenameRu',$i);
                    $t = &$table[$i];
                    $matches = [];
                    preg_match_all("|<tr>\R<td>([0-9]+)</td>\R<td>.*</td>\R<td>.*</td>\R<td>.*</td>\R<td>(.+)</td>\R<td>(.+)</td>|sU",
                        $t, $matches);
                    // [0=>fullMatch,...], [1=>[id{000},...], 2=>[CapitalizedEng,...], 3=>[CapitalizedRussian_optionally_with_anchor,...]
                    // NB! Names in English are capitalized and may contain ♀ & ♂
                    // unset ($matches[0]);

                    // make values
                    foreach ($matches[1] as $k=>$pokeid) {
                        $ru = $matches[3][$k];
                        // remove anchor
                        if ($ru[0]=='<') {
                            $m=[];
                            preg_match("|<[^>]+>(.*)<\/a>|sU",$ru,$m);
                            $ru=$m[1];
                            // remove gender symbol?
                        }
                        // add
                        $name_ru[0+$pokeid] = $ru;
                    }

                }
                // logMessage('FetchPokenameRu',varExport($name_ru));

                // update pokename using _GET[pokeid] _GET[pokecount]
                $report = [];
                for ($i=0;$i<$_GET['pokecount'];$i++) {
                    if (isset($name_ru[$_GET['pokeid']])) {
                        // make update
                        if (!$tbPokename->update(
                            ['pokename_ru'=>$name_ru[$_GET['pokeid']]],
                            false,
                            'pokeid='.$_GET['pokeid']
                            )){
                            logMessage('FetchPokenameRu',sqlError(),'danger');
                        } else {
                            $report[]= $_GET['pokeid'].'='.$name_ru[$_GET['pokeid']];
                        }
                    }
                    $_GET['pokeid']++;
                }
                if (count($report)) {
                    logMessage('FetchPokenameRu',implode('; ',$report),'success');
                }
            }
            break;
    }
}