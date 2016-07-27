<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 27/07/2016
 * Time: 10:46
 */

class dbTable {
    public $name;
    public $spec;
    public $DBH;


    function __construct($dbh,$tbname,$tbspec) {
        $this->name = $tbname;
        $this->spec = $tbspec;
        $this->DBH = $dbh;
    }

    public function exists() { return sqlTableExists($this->name); }

    public function create($dropifexists=false) {
        $exists = $this->exists();
        if ($exists && !$dropifexists)
            return false;
        if ($exists && $dropifexists)
            $this->drop();

    }

    public function drop() {
        $this->DBH->real_query('DROP TABLE `'.$this->name.'`');
    }

    public function insert($values,$fdlist) {

    }

    public function insertRecord($values) {

    }

    public function insertRecordSet($values) {

    }

    public function mkStatementCreate() {
        $statement = 'CREATE TABLE IF NOT EXISTS `'.$this->name.'` (';
        $flist = [];
        foreach ($this->spec['f'] as $fd=>$spec)
            $flist [] = $fd.' '.$spec;
        foreach ($this->spec['fx'] as $fd=>$spec)
            $flist [] = (is_numeric($fd)?'':$fd.' ').$spec;
        $statement .= implode(',',$flist).')';
        return $statement;
    }

    public function mkStatementInsert_prefix($fdlist=false) {
        if (!$fdlist) $fdlist = array_keys($this->spec['f']);
        return 'INSERT INTO `'.$this->name.'`('.implode(',',$fdlist).') VALUES ';
    }

}