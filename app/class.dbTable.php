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
        return $this->DBH->query($this->mkStatementCreate());
    }

    public function drop() {
        return $this->DBH->query('DROP TABLE `'.$this->name.'`');
    }

    public function insert($valueset,$fdlist=false) {
        if (!is_array($valueset))
            $valueset = [$valueset]; // make array
        if (!is_array($valueset[0]))
            $valueset=[$valueset];  // make arra of arrays - valueset
        if (!$fdlist)
            $fdlist = array_keys($this->spec['f']); // take fieldlist from spec
        $statement = $this->mkStatementInsert_prefix($fdlist) // make 'INSERT... (fields...) VALUES '
            . $this->mkStatementInsert_ValueSet($valueset)
            . ';';
        return $this->DBH->query($statement);
    }

    /**
     * @param $valueset
     * @return string : ('value','value'), ('value','value')...
     */
    public function mkStatementInsert_ValueSet($valueset) {
        $spec = [];
        foreach ($valueset as $record)
            $spec [] = $this->mkStatementInsert_Values($record);
        return implode(',',$spec);
    }

    /**
     * @desc generates sanitized VALUES set for a single record
     * @param $values
     * @return string : ('value','value'...)
     */
    public function mkStatementInsert_Values($values) {
        sqlSanitizeRecord($values);
        return '(\''.implode('\',\'',$values).'\')';
    }


    public function mkStatementCreate() {
        $statement = 'CREATE TABLE IF NOT EXISTS `'.$this->name.'` (';
        $flist = [];
        foreach ($this->spec['f'] as $fd=>$spec)
            $flist [] = $fd.' '.$spec;
        foreach ($this->spec['fx'] as $fd=>$spec)
            $flist [] = (is_numeric($fd)?'':$fd.' ').$spec;
        $statement .= implode(',',$flist).');';
        return $statement;
    }

    public function mkStatementInsert_prefix($fdlist=false) {
        if (!$fdlist) $fdlist = array_keys($this->spec['f']);
        return 'INSERT INTO `'.$this->name.'`('.implode(',',$fdlist).') VALUES ';
    }

}