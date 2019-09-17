<?php

class wuuQuery{
    public $table;
    private $query  = "";
    private $fields = "*";
    private $where;
    private $limit;
    private $offset =" OFFSET 0";
    private $by;
    private $order  = " ASC";
    public function table($table){ 
        $this->table = strtolower($table);
        return $this; 
    }
    public function query(){
        $this->query  = "";
        $this->query .= ($this->where)? $this->where : "";
        $this->query .= ($this->by)?    $this->by.$this->order:"";
        $this->query .= ($this->limit)? $this->limit.$this->offset:"";
        return $this->query;
    }
    public function where(Array $fields){
        $str    = " WHERE ";
        $size   = count($fields);
        $count  = 0;
        foreach($fields as $k => $field){
            $count++;
            $str.= "`{$field[0]}` {$field[1]} '{$field[2]}'";
            $str.= ($count == $size) ? "" : " AND " ; 
        }
        $this->where = $str;
        return $this;
    }
     /**
     * Generate and set fields from Array os fields
     *
     * @param Array $fields
     * @return self
     */
    public function updateFields($object){
        $fields = get_object_vars($object);
        $str    = "";
        $size   = count($fields);
        $count  = 0;
        foreach($fields as $k => $field){
            $count++;
            $str.= "`{$k}` = ";
            $str .= (gettype($field) != "string") ? "'".json_encode($field)."'" : "'{$field}'";
            $str.= ($count == $size) ? "" : ", " ; 
        }
        $this->fields = $str;
        return $this;
    }
    /**
     * Generate and set fields from Array os fields
     *
     * @param Array $fields
     * @return self
     */
    public function selectFields($fields){
        $str    = "";
        $size   = count($fields);
        $count  = 0;
        foreach($fields as $k => $field){
            $count++;
            $str.= ($count == $size) ? "`{$field}`" : "`{$field}`," ; 
        }
        $this->fields = $str;
        return $this;
    }
    public function insertFields($fields){
        $vars   = get_object_vars($fields);
        $keys   = '';
        $value  = '';
        $size = count($vars);
        $count = 0;
        foreach($vars as $var => $val){
            $count++;            
            $keys   .= "`{$var}`";
            $value .= (gettype($val) != "string") ? "'".json_encode($val)."'" : "'{$val}'";
            if($count < $size){
                $keys   .= ",";
                $value  .= ",";
            }
        }
        $this->fields = $keys;
        return $value;
    }
    public function by($field){
        $this->by  = " ORDER BY `{$field}`";
        return $this;
    }
    public function order($order){
        $this->order  = " {$order}";
        return $this;
    }
    public function limit($limit){
        $this->limit  = " LIMIT {$limit}";
        return $this;
    }
    public function offset($of){
        $this->offset  = " OFFSET {$of}";
        return $this;
    }
    public function page($pg){
        $limit = intval( str_replace("LIMIT","",$this->limit) );
        $of = $limit * ($pg-1);
        $this->offset($of);
        return $this;
    }
    private function reset(){
        $this->fields   = "*";
        $this->where    = false;
        $this->limit    = false;
        $this->offset   = " OFFSET 0";
        $this->by       = false;
        $this->order    = " ASC";
        return $this;
    }
    /**
     * 
     * END POINTS
     *
     */
    public function select(){
        $query = "SELECT {$this->fields} FROM `{$this->table}`".$this->query();
        $this->reset();
        return $query;
    }
    public function update(){
        $query = "UPDATE `{$this->table}` SET {$this->fields}".$this->query();
        $this->reset();
        return $query;
    }
    public function delete(){
        $query = "DELETE FROM `{$this->table}` ";
        return $query.$this->query();
    }
    public function insert($values){
        $query = "INSERT INTO `{$this->table}`";
        return "{$query} ({$this->fields}) VALUES ({$values})";
    }
}