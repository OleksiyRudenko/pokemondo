<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 25/07/2016
 * Time: 19:03
 */

print '<div>index.php?b=<i>n</i>&e=<i>m</i></div>';

if (isset($_GET['b']) && isset($_GET['e']))
    for ($i=$_GET['b'];$i<=$_GET['b'];$i++)
        print '<div>'.$i.'</div>';
else
    print '<div>index.php?b=<i>n</i>&e=<i>m</i></div>';
