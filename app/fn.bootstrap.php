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

/**
 * @param string $aria : aria-label
 * @param integer $page : page nr (1-based) ...
 * @param integer $pages : ... of pages
 * @param $s :  [maxN=>maxPagebttns, edgeN=>pgBttnsInBeginning/End, aroundN=>pgBttnsAroundTargetPage, prevnext=>bool, everyNth => bool]
 * @return string
 * Examples:
 * < 1 2 3 4 5 6 >
 * < 1 ... 6 7 8 9 10 ... 20 >
 * < 1 2 3 4 5 6 7 ... 20 >   // 2 added in place of ellipsis since it doesn't save space
 * < 1 2 3 4 ... 10 ... 20 ... 25 > // every=10
 */
function paginator($aria, $page, $pages, $s=[
    'minN' => 20,
    'edgeN' => 1,
    'aroundN' => 2,
    'prevnext' => true,
    'everyNth'    => true,
]) {
    $rwff = false; // fastForward/fastRewind buttons false|integer depending on $pages scale
    if ($pages<1) return '';
    $pageno = [];
    if ($pages<=$s['minN']) {
        for ($i=1;$i<=$pages;$i++) $pageno[$i]=$i;
    } else {
        // place edges
        for ($i=0;$i<$s['edgeN'];$i++) {
            if ($i+1<=$pages) $pageno[$i+1]=$i+1;
            if ($pages-$i>0) $pageno[$pages-$i]=$pages-$i;
        }
        // place everyNth
        if ($s['everyNth']) {
            /*
             * pages>110 every 10th within 100 around page + every 100th if
             * pages>1'100 every 100th within 100 around page + every 100th if below next
             * pages>11'000 every 1000th within 1'000 around page + every 1'000th if below next
             * pages>110'000 every 1'000th within 10'000 around page + every 10'000th if below next
             * pages>1'100'000 every 10'000th within 100'000 around page + every 100'000th
             * pages> every 100'000th within 1'000'000 around page + every 1'000'000th
             */
            for ($l=100;$l<PHP_INT_MAX;$l*=10) {
                paginatorPopulate($pageno,$page,$pages,$l);
                if ($l>$pages) break;
            }


            /* for ($i=$s['every'];$i<$pages;$i+=$s['every'])
                $pageno[$i] = $i; */
        }
        if ($pages>200)
            $rwff = round($pages/5,-1);
        // place $page
        if ($page>0 && $page<=$pages) {
            $pageno[$page]=$page;
            // place around
            for ($i=0;$i<$s['aroundN'];$i++) {
                if ($page-$i-1>0) $pageno[$page-$i-1]=$page-$i-1;
                if ($page+$i+1>0) $pageno[$page+$i+1]=$page+$i+1;
            }
        }
        // fill gaps wisely
        $ingap = false;
        for ($i=1;$i<=$pages;$i++) {
            if (isset($pageno[$i])) {
                $ingap = false;
            } else {
                if (isset($pageno[$i+1])) {
                    if (!$ingap) {
                        $pageno[$i]=$i;
                        $ingap=true;
                    }
                } else {
                    if (!$ingap) {
                        $pageno[$i]='&hellip;';
                        $ingap=true;
                    }
                }
            }
        }
    }
    ksort($pageno);

    // return alert($page.'/'.$pages.varExport($pageno).'rwff='.$rwff,'info');

    if ($s['prevnext']) {
        if (($pgPrev=$page-1)<1) $pgPrev=1;
        if (($pgNext=$page+1)>$pages) $pgNext=$pages;
    }
    if ($rwff) {
        if (($pgRewind=$page-$rwff)<1) $pgRewind=1;
        if (($pgFastForward=$page+$rwff)>$pages) $pgFastForward=$pages;
    }

    // convert $pageno into list items
    $li =[];
    foreach ($pageno as $pgno) {
        $notclickable = ($page==$pgno || $pgno=='&hellip;') ? true : false;
        if ($notclickable) {
            $class = ($page==$pgno) ? 'active':'disabled';
        }

        $li[]='<li'.($notclickable?' class="'.$class.'"':'').'>'
            .($notclickable?'<span>':'<a href="?pg='.$pgno.'" aria-label="'.$pgno.'">')
            .$pgno
            .($notclickable?'<span class="sr-only">(current)</span></span>':'</a>')
            .'</li>';
    }

    return '<nav aria-label="'.$aria.'"><ul class="pagination">'
        .($rwff
            ? '<li'.($page==1?' class="disabled"':'').'>'
                .($page==1?'<span>':'<a href="?pg='.$pgRewind.'" aria-label="Rewind">')
                .'<span aria-hidden="true">&laquo;</span>'
                .($page==1?'</span>':'</a>')
                .'</li>'
            :'')
        .($s['prevnext']
            ? '<li'.($page==1?' class="disabled"':'').'>'
                .($page==1?'<span>':'<a href="?pg='.$pgPrev.'" aria-label="Previous">')
                .'<span aria-hidden="true">&lsaquo;</span>'
                .($page==1?'</span>':'</a>')
                .'</li>'
            :'')
        .implode("\n",$li)
        .($s['prevnext']
            ? '<li'.($page==$pages?' class="disabled"':'').'>'
                .($page==$pages?'<span>':'<a href="?pg='.$pgNext.'" aria-label="Previous">')
                .'<span aria-hidden="true">&rsaquo;</span>'
                .($page==$pages?'</span>':'</a>')
                .'</li>'
            :'')
        .($rwff
            ? '<li'.($page==$pages?' class="disabled"':'').'>'
                .($page==$pages?'<span>':'<a href="?pg='.$pgFastForward.'" aria-label="Fast forward">')
                .'<span aria-hidden="true">&raquo;</span>'
                .($page==$pages?'</span>':'</a>')
                .'</li>'
            :'')
    .'</ul></nav>';
}

function paginatorPopulate(&$pglist,$page,$pages,$l) {
    if (($begin = $page-$l/2)<10) $begin=10;
    if (($end = $page+$l/2) > $pages) $end=$pages;
    $step = $l/10;
    // roundup $begin to nearest $begin%$step=0
    // rounddown $end to nearest $end%$step=0
    if (($begin = round($begin,-(strlen($step)-1)))<1) $begin=1;
    if (($end = round($end,-(strlen($step)-1)))>$pages) $end=$pages;

    for ($i=$begin;$i<$end;$i+=$step) {
        $pglist[$i]=$i;
    }
}

/* Paginator tests & examples:
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