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
    private static $SELECT_CLAUSES = [
        'WHERE','GROUP BY','HAVING','ORDER BY','LIMIT'
    ];

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

    public function drop($ifexists=false) {
        return $this->DBH->query('DROP TABLE '.($ifexists?' IF EXISTS':'').'`'.$this->name.'`');
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
     * @param mixed $field : false=*|array
     * @param mixed $component : false=none|string append after 'FROM tbname'|array
     *
     * component array = [
     *      prefix      => 'e.g. DISTINCT',
     *      fs          => [append-to-fields-list,...],
     *      join        => [ [ JOIN-PREDICATE, table-as, JOIN-CLAUSE], ... ], -- can be not nested
     *      WHERE       => 'where clause'
     *      GROUP BY    => 'group-by clause',
     *      HAVING      => 'having clause',
     *      ORDER BY    => 'order-by clause',
     *      LIMIT       => 'limit clause',
     *      ending      => 'appended to the end of clause',
     * ]
     * NB! If join component present then principal table aliased as t1.
     * Allcaps keywords added automatically
     * TODO: implement optional t1.*, t2.*...
     */
    public function select($field=false, $component=false) {
        if (!$field) $field='*';
        if (!is_array($field)) $field=[$field];
        if (!$component) $component = [];
        if (!is_array($component)) $component['ending']=$component; // convert string into ending=>

        $statement[] = 'SELECT';
        if (count($component)) {
            if (isset($component['prefix']))
                $statement[]=$component['prefix'];
            if (isset($component['fs']))
                $field=array_merge($field,$component['fs']);
        }
        $statement[]=implode(',',$field);
        $statement[]='FROM '.$this->name.(isset($component['join'])?' AS t1':'');
        if (count($component)) {
            if (isset($component['join'])) {
                if (!is_array($component['join'][0]))
                    $statement[] = implode(' ', $component['join']);
                else
                    foreach ($component['join'] as $join)
                        $statement[] = implode(' ', $join);
            }
            foreach (self::$SELECT_CLAUSES as $clause)
                if (isset($component[$clause]))
                    $statement[] = $clause
                        . ' '
                        . $component[$clause];
            if (isset($component['ending']))
                $statement[] = $component['ending'];
        }

        return $this->DBH->query(implode(' ',$statement));
    }

    /**
     * @param string $field : field to count by
     * @param mixed $component : optional selection statements
     * @return mixed : false on error; int on success
     */
    public function countRows($field,$component=false) {
        $qr = $this->select('COUNT('.$field.') AS cnt',$component);
        if (!$qr || !$qr->num_rows) return false;
        $row = $qr->fetch_assoc();
        $qr->free();
        $count = $row['cnt'];
        return $count;
    }

    public function fields() {
        return array_keys($this->spec['f']);
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