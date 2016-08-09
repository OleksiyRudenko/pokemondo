<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 26/07/2016
 * Time: 17:37
 */

class MODULE {
    // initial settings
    public static $pathtree;
    public static $settings;
    public static $viewSchema;

    // computed derivative settings
    public static $path = [];

    // current module property references
    public static $currSetting;
    public static $currTreeProps;
    public static $currMod;         // current module name

    public static function initialize(&$ptree,&$stngs,&$views) {
        self::$pathtree = &$ptree;
        self::$settings = &$stngs;
        self::$viewSchema = &$views;

        // build-up pathtree
        self::traverse(self::$pathtree,'pathtreeComplete');
        // supplement settings with urls for navigation
        self::makeUrls(self::$pathtree);
        // prepend ARGV with default module unless defined
        if ((count(ARGV::$a) && !isset(self::$pathtree[ARGV::$a[0]])) || !count(ARGV::$a)) {
            // ARGV[0] not registered as default path (1st in a key list) or ARGV is empty
            // then insert first key from pathtree into ARGV
            foreach (self::$pathtree as $firstkey=>$val) break;
            array_unshift(ARGV::$a,$firstkey);
        }
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

    public static function loadPreHTML() { self::load('preHTML'); }

    public static function loadView() { self::load('view'); }


    public static function showView() {

    }

    private static function buildPath($tree) {
        if (!count(ARGV::$a)) return;
        // logMessage('DEBUG',varExport($tree,'MODULE::buildPath() tree'));
        // logMessage('DEBUG',varExport(ARGV::$a,'MODULE::buildPath() ARGV'));
        foreach ($tree as $k=>$a) {
            if (ARGV::$a[0]==$k) {
                self::$path[]=array_shift(ARGV::$a);
                if (is_array($a))
                    self::buildPath($a['child']);
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

    // ====================================

    /**
     * @desc  Copy umask from parentNode unless is set. Build up ['url']
     * @param $node
     * @param $parentNode
     */
    private static function pathtreeComplete(&$node, $nodeid, &$parentNode) {
        // inherit [umask] from parent unless isset
        if (!isset($node['umask']))
            $node['umask'] = ($parentNode)?$parentNode['umask']:UMASK_GUEST;
        // inherit [viewSchema] from parent unless isset
        if (!isset($node['viewSchema']))
            $node['viewSchema'] = ($parentNode)?$parentNode['viewSchema']:'private';
        // build-up [uri] using parentNode[uri]
        if (!isset($node['uri']))
            $node['uri'] = (($parentNode)?$parentNode['uri'].'/':'').$nodeid;
    }

    // ==================================== secondary services

    /**
     * @desc  Traverse tree represented with array
     * @param $tree
     * @param $callback
     * @param null $parentNode
     * @param string $subtreecontainer
     */
    private static function traverse(&$tree, $callback, &$parentNode=NULL, $subtreecontainer='child') {
        foreach ($tree as $nodeid=>$a) {
            if (!is_array($a)) {
                $tree[$nodeid] = [ $subtreecontainer=>0 ];
            }
            if (!isset($tree[$nodeid][$subtreecontainer])) {
                $tree[$nodeid][$subtreecontainer]=0;
            }
            MODULE::$callback($tree[$nodeid],$nodeid,$parentNode);
            if ($tree[$nodeid][$subtreecontainer])
                self::traverse($tree[$nodeid][$subtreecontainer],$callback,$tree[$nodeid]);
        }
    }


    // ====================================  DEBUG

    public static function exportProperties() {
        return [
            'PATHTREE'=>self::$pathtree,
            'PATH'=>self::$path,
            'CURRMOD'=>self::$currMod,
            'CURRSETTING'=>self::$currSetting,
            'SETTINGS'=>self::$settings,
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