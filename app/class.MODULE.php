<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 26/07/2016
 * Time: 17:37
 */

class MODULE {
    public static $pathtree;
    public static $path = [];
    public static $settings;
    public static $currSetting;
    public static $currMod;

    public static function initialize(&$ptree,&$stngs) {
        self::$pathtree = $ptree;
        self::$settings = $stngs;

        if ((count(ARGV::$a) && !isset(self::$pathtree[ARGV::$a[0]])) || !count(ARGV::$a)) {
            // ARGV[0] not registered as default path (1st in a key list) or ARGV is empty
            // then insert first key from pathtree into ARGV
            foreach (self::$pathtree as $firstkey=>$val) break;
            array_unshift(ARGV::$a,$firstkey);
        }
        // supplement settings with urls for navigation
        self::makeUrls(self::$pathtree);
        // find current module
        self::buildPath(self::$pathtree);
        self::$currMod = self::$path[count(self::$path)-1];
        // make reference to current module setting
        self::$currSetting = &self::$settings[self::$currMod];
    }

    public static function currSetting($stng) {
        return isset(self::$currSetting[$stng])
            ? self::$currSetting[$stng]
            : false;
    }

    public static function getSetting($stng,$module=false) {
        if (!$module) $module = self::$currMod;
        return self::$settings[$module][$stng];
    }

    public static function load($component) {
        include_once('app/'.MODULE::currSetting('basepath').'.'.$component.'.php');
    }

    public static function loadOnSubmit() { self::load('onSubmit'); }

    public static function loadView() { self::load('view'); }

    private static function buildPath($tree) {
        if (!count(ARGV::$a)) return;
        // logMessage('DEBUG',varExport($tree,'MODULE::buildPath() tree'));
        // logMessage('DEBUG',varExport(ARGV::$a,'MODULE::buildPath() ARGV'));
        foreach ($tree as $k=>$a) {
            if (ARGV::$a[0]==$k) {
                self::$path[]=array_shift(ARGV::$a);
                if (is_array($a))
                    self::buildPath($a);
                break;
            }
        }
    }

    private static function makeUrls($tree,$path='') {
        foreach ($tree as $k=>$a) {
            self::$settings[$k]['url'] = $path.'/'.$k;
            if (is_array($a)) {
                self::makeUrls($a,$path . '/' . $k);
            }
        }

    }

    // ====================================  DEBUG

    public static function exportProperties() {
        return [
            self::$pathtree,
            self::$path,
            self::$currMod,
            self::$currSetting,
            self::$settings
        ];
    }

    // ========================== bootstrap helpers ======================

    public static function navbarNested() {
        // output should be put into <ul class="nav navbar-nav"></ul>
        return self::makeNavList(self::$pathtree);
    }

    private static function makeNavList($tree) {
        $ret = [];
        foreach ($tree as $k=>$a) {
            $isa = is_array($a);
            $ret[] = '<li'.($isa?' class="dropdown"':'').'>'
                . '<a'.($isa?' class="dropdown-toggle" data-toggle="dropdown"':'')
                    .' href="'
                    . (MODULE::$currMod == $k ? ($isa?'#':'#section-'.$k) : MODULE::$settings[$k]['url'])
                    // current module refer to as '#' -- to make toggling available
                    .'">'
                . MODULE::$settings[$k]['navmenu']
                . ($isa?'<span class="caret"></span>':'')
                . '</a>'
                . ($isa
                    ?'<ul class="dropdown-menu">'
                        . self::makeNavList($a)
                        . '</ul>'
                    :'')
                . '</li>'
                ;
        }
        return implode("\n",$ret);
    }

/*     private static function makeHref($mod) {

    } */

}