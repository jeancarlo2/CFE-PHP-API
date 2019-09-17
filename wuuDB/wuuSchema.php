<?php

class wuuSchema{
    private $json;      // Storage original json
    private $schema;    // Storage schema types
    public function __construct(stdClass $obj){
        $this->json = $obj;
        $this->schema = (object)[];
        $this->object = (object)[];
        $vars = get_object_vars($obj);
        foreach($vars as $var => $value){
            // $this->object->{$var} = null;
            $this->schema->{$var} = new wuuField($var, $value);
        }
    }
    function fields(){ return $this->schema; }
    /**
     * Retorna um array de arrays com as configurações do mysql
     *
     * @return array of arrays
     */
    public function mysql(){
        $vars   = get_object_vars($this->schema);
        $types  = [];
        foreach($vars as $var => $value){
            $types[$var] = $value->_mysql;
        }
        return $types;
    }
}