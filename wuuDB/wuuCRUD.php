<?php 

class wuuCRUD extends wuuQuery{
    public $result;
    public $_id; #id for delete, update or lastInsertId
    public function __construct($table=""){ 
        $this->table($table);
    }
    public function C($object){
        $values = $this->insertFields($object);
        $this->result = wuuDB::query($this->insert($values));
        return $this->_id = wuuDB::$pdo->lastInsertId();
    }
    /**
     * R:: Le dados no banco de dados
     *
     * @param string $table
     * @param string $where
     * @param string $fields
     * @return void
     */
    public function R(){
        $this->result = wuuDB::query($this->select());
        return $this->result->fetchAll();
    }
    public function U($object){
        $this->updateFields($object);
        if($this->_id) $this->where([ ["_id","=",$this->_id] ]);
        $this->result = wuuDB::query($this->update());
        return  ($this->result->rowCount()) ? $this->result->rowCount() :false;
    }
    public function D(){
        if($this->_id) $this->where([ ["_id","=",$this->_id] ]);
        $this->result = wuuDB::query($this->delete());
        return ($this->result->rowCount()) ? $this->result->rowCount() :false;
    }
}