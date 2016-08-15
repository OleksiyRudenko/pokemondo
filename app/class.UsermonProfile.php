<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 02/08/2016
 * Time: 13:06
 */

include_once('app/class.Pokemon.php');
include_once('app/fn.gd.php');

class UsermonProfile {
    public static $path = [
        'useravabase'       =>  'img/user/ava/',    // id.jpg - user avatar
        'userprofilebase'   =>  'img/user/profile/',    // id.jpg - user result picture for og::
        'tplimg'            =>  'img/user/tpl-txt.png', // template
    ];

    public static $poketypeclassElement = [
        'dark', 'ice', 'grass', 'ground', 'steel', 'fire', 'rock', 'water', 'electric',
    ];

    public static $font = [
        // source: http://www.fonts2u.com/
        'username'  =>  'ttf/FreeSerif.ttf', // 'ttf/DejaVuSansMono-Bold.ttf',
        'pokename'  =>  'ttf/fancyserif.ttf', // 'ttf/Ozme.TTF',
    ];

    public static $pokemonList = [];
    public static $currentProfile = NULL;

    public $currentPokemon;

    private $u = [
        'id'            =>  0,
        'gender'        => 'x',
        'name'          => '',
        'birthdate'     => '01/31/2000', // MM/DD/YYYY
    ];

    function __construct($userid,$username,$gender='',$birthdate='') {
        $this->u = is_array($userid)
            ? $userid
            : [
                'id'            =>  $userid,
                'name'          =>  $username,
                'gender'        =>  $gender,
                'birthdate'     =>  $birthdate,
              ];
    }

    function getProps() {
        return $this->u;
    }

    function profileImgTag($headslash=true,$randomPrefix=false) {
        return htmlElementSingle('img',['src'=>$this->getUserProfileImagename($headslash,$randomPrefix)]);
    }


    /**
     * @desc   Gets pokemons that meet user criteria
     * @return array : [class.Pokemon,...]
     */
    function selectPokemons($addNonElemental=true) {
        global $DBH, $DBT;
        include_once('app/class.dbTable.php');
        include_once('app/dbSpec/db.tables.php');

        $pokelist = [];
        // allowed genders
        $pokegender = ['x', 'n'];
        if ($this->u['gender']=='f' || $this->u['gender']=='m')
            $pokegender[]=$this->u['gender'];
        $genderlist = '(\''.implode('\',\'',$pokegender).'\')';

        $poketype=$this->getElement();
        $tb = new dbTable($DBH,'poketype',$DBT['poketype']);
        $clauses = [
            'join'  => [
                'RIGHT JOIN pokegender AS t2 ON t2.pokeid=t1.pokeid AND t2.gender IN '.$genderlist,
                'LEFT JOIN pokename AS t3 ON t3.pokeid=t1.pokeid'
            ],
            'WHERE' => 't1.poketype=\''.$poketype.'\'',
            // 't1.pokegender in (\''.implode('\',\'',$pokegender).'\')',
        ];
        if ($qr=$tb->select('*',$clauses)) {
            while ($row=$qr->fetch_assoc()) {
                $pokelist[] = new Pokemon($row);
            }
        } else {
            logMessage('UsermonProfile','UsermonProfile::selectPokemons(): '.sqlError(),'danger');
            return $pokelist;
        }
        // logMessage('UsermonProfile','UsermonProfile::selectPokemons().list.pass1: '.varExport($pokelist));


        if ($addNonElemental) {
            /*
             *  SELECT * FROM
                    (SELECT t1.*, t2.gender, t3.pokename, t3.pokename_ru FROM
                        (SELECT t21.*, t22.poketypeclass, t22.poketype_ru FROM `poketype` AS t21
                        JOIN `poketype_ru` AS t22 on t21.poketype=t22.poketype
                        ORDER BY t22.poketypeclass) as t1
                    RIGHT JOIN `pokegender` AS t2 ON t1.pokeid=t2.pokeid AND t2.gender IN ('x','n','f')
                    LEFT JOIN `pokename` AS t3 ON t1.pokeid=t3.pokeid
                    GROUP BY t1.pokeid
                    HAVING t1.poketypeclass<>'element') AS supert
                ORDER BY RAND()
                LIMIT 5
             *
             */

            global $DBH;
            if ($qr=$DBH->query(
                'SELECT * FROM'
                    .' (SELECT t1.*, t2.gender, t3.pokename, t3.pokename_ru FROM'
                        .' (SELECT t21.*, t22.poketypeclass, t22.poketype_ru FROM `poketype` AS t21'
                        .' JOIN `poketype_ru` AS t22 on t21.poketype=t22.poketype'
                        .' ORDER BY t22.poketypeclass) as t1'
                    .' RIGHT JOIN `pokegender` AS t2 ON t1.pokeid=t2.pokeid AND t2.gender IN '.$genderlist
                    .' LEFT JOIN `pokename` AS t3 ON t1.pokeid=t3.pokeid'
                    .' GROUP BY t1.pokeid'
                    .' HAVING t1.poketypeclass<>\'element\') AS supert'
                .' ORDER BY RAND() LIMIT 5'
                )) {
                while ($row=$qr->fetch_assoc()) {
                    $pokelist[] = new Pokemon($row);
                }
            } else {
                logMessage('UsermonProfile','UsermonProfile::selectPokemons().extra: '.sqlError(),'danger');
                return $pokelist;
            }
        }
        // logMessage('UsermonProfile','UsermonProfile::selectPokemons().list.pass2: '.varExport($pokelist));

        return $pokelist;
    }

    function getElement() {
        $poketypeNr=0;
        /*
         * 0000-00-00 - SQL Style YYYY-MM-DD
         * 00-00-0000 - FB Style MM-DD-YYYY
         */
        $date = $this->u['birthdate'];
        $fbstyle = ($date[4]=='-') ? false : true;
        $day =  substr($date,($fbstyle?3:8),2);
        $month = substr($date,($fbstyle?0:5),2);
        if (strlen($this->u['birthdate'])>4) {
            $DOY=round($month*30.4+$day);
            $poketypeNr=floor($DOY/46)+1;
        }
        return self::$poketypeclassElement[$poketypeNr];
    }

    /*
     * Pokemon local ava dims:
     *   215x215
     * FB user avatar dims:
     *   http://graph.facebook.com/67563683055/picture?type=
     *      square   50 x  50
     *      small    50 x  50
     *      normal  100 x 100
     *      large   200 x 200
     * Normal og-image template dims:
     *   800x420
     *
     * Template presets:
     *  userAva-bgRect
     *      margins     8 8 8 3
     *      loc         90;48
     *      dims        216x211
     *  userAva
     *      loc         userAva-bgRect.loc +(8;8)
     *      dims        200x200
     *  userName-bgRect
     *      margins     8 3 8 8
     *      loc         userAva-bgRect.loc +(0;211) = (90;259)
     *      dims        216x43
     *  userName-printArea
     *      loc         userName-bgRect.loc +(8;3)
     *      dims        200x32
     *  pokeAva-bgCircle
     *      center      userAva.loc +(?;100)
     *      R           100
     *  pokeAva
     *      loc         (494;48)
     *      dims        215x215
     *  pokeName-bgRect
     *      margins     8 3 8 8
     *      loc         bgRect.loc +(0;211) = (494;259)
     *      dims        216x43
     *  pokeName-printArea
     *      loc         userName-bgRect.loc +(8;3)
     *      dims        200x32
     */

    /**
     * @desc  Create profile image
     * @param $pokemon Pokemon
     */
    function createProfileImg($pokemon=false) {
        if (!$pokemon)
            $pokemon = $this->currentPokemon;
        logMessage('UsermonProfile','UsermonProfile::createProfileImg().entered');
        // load template
        if (!$img = imagecreatefrompng(self::$path['tplimg'])) {
            logMessage('UsermonProfile','UsermonProfile::createProfileImg() error reading TEMPLATE '.self::$path['tplimg'],'danger');
            return false;
        }

        // load user avatar
        if (!$imgAva = imagecreatefromjpeg($this->getUserAvaFilename())) {
            logMessage('UsermonProfile','UsermonProfile::createProfileImg() error reading USERavatar '.$this->getUserAvaFilename(),'danger');
            return false;
        }
        // merge user avatar
        if (!imagecopy($img,$imgAva,98,56,0,0,200,200)) {
            logMessage('UsermonProfile','UsermonProfile::createProfileImg() error merging USERavatar '.$this->getUserAvaFilename(),'danger');
            return false;
        }
        imagedestroy($imgAva);
        // load pokemon avatar
        if (!$imgPoke = imagecreatefrompng($pokemon->imageFilename('avatar','static','normal'))) {
            logMessage('UsermonProfile','UsermonProfile::createProfileImg() error reading POKEMONavatar '.$pokemon->imageFilename('avatar','static','normal'),'danger');
            return false;
        }
        // merge pokemon avatar
        if (!imagecopy($img,$imgPoke,494,48,0,0,215,215)) {
            logMessage('UsermonProfile','UsermonProfile::createProfileImg() error merging POKEMONavatar '.$this->getUserAvaFilename(),'danger');
            return false;
        }
        imagedestroy($imgPoke);
        // detect text color
        $textcolor=-1;
        for ($i=3;$i<20 && $textcolor==-1;$i++)
            $textcolor=imagecolorexact($img,$i,$i,$i);
        // add user name
        $tdims=$this->textSize('username',$this->u['name'],200,30);
        $dx = (200-$tdims[0])/2;
        $dy = (32-$tdims[1])/2;
        imagefttext(
            $img,
            $tdims[2],
            0,
            98+$dx,
            259+3+$dy+$tdims[1]-3,
            $textcolor,
            $this->getFontFilename('username'),
            $this->u['name']
        );

        // add avatar name
        $tdims=$this->textSize('pokename',$pokemon->p['pokename_ru'],200,32);
        $dx = (200-$tdims[0])/2;
        $dy = (32-$tdims[1])/2;
        imagefttext(
            $img,
            $tdims[2],
            0,
            494+8+$dx,
            259+3+$dy+$tdims[1]-3,
            $textcolor,
            $this->getFontFilename('pokename'),
            $pokemon->p['pokename_ru']
        );


        // save $img
        imagealphablending($img, false);
        imagesavealpha($img, true);
        if (!imagejpeg($img,$this->getUserProfileImagename(),90)) {
            logMessage('UsermonProfile','UsermonProfile::createProfileImg() error saving PROFILEimage '.$this->getUserProfileImagename(),'danger');
            return false;
        }
        // free resource
        imagedestroy($img);
        logMessage('UsermonProfile','UsermonProfile::createProfileImg().complete');
    }

    function getUserAvaFilename() {
        return self::$path['useravabase'].$this->u['id'].'.jpg';
    }

    function getUserProfileImagename($headslash=false,$randomPrefix=false) {
        $imgfilename = self::$path['userprofilebase'].$this->u['id'].'.jpg';
        return
            ($headslash?'/':'')
            .$imgfilename
            .($randomPrefix
            ?'?'.filemtime($imgfilename)
            :'');
    }
    function userProfileImageExists() {
        return file_exists($this->getUserProfileImagename());
    }

    /**
     * @param $fontid : which font to use
     * @param $text
     * @param $maxwidth
     * @param $maxheight
     * @return array [width,height,size]
     */
    function textSize($fontid, $text, $maxwidth, $maxheight) {
        $size=32;
        do {
            $size-=2;
            $bbox=imageftbbox($size,0,$this->getFontFilename($fontid),$text); // llx,lly, lrx,lry, urx,ury, ulx,uly
            $width = $bbox[2]-$bbox[0];
            $height = $bbox[3]-$bbox[5];
        } while ($size>5 && ($bbox[4]>$maxwidth || $bbox[3]>$maxheight));
        $rdims = [
          $width,$height,$size,
            $bbox
        ];
        // logMessage('UsermonProfile','UsermonProfile::textSize('.$fontid.','.$text.')='.varExport($rdims));
        return $rdims;
    }

    function getFontFilename($fontid) {
        return self::$font[$fontid];
    }
}