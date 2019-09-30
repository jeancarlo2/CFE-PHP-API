<?php
class wuuField{
    public $name; #name of field
    public $type; #type of field
    public $value; #value of field
    public $default;
    public $description;
    public $mysql;
    public $_mysql;
    public function __construct($name, $field){
            $this->name = $name;
            $this->type = strtolower($this->fieldType($field));
            if( isset($field->default) ){
                if(is_callable($field->default)) $this->default             = get_object_vars($field)["default"]();
                elseif( function_exists($field->default) ) $this->default   = call_user_func($field->default);
                else $this->default                                         = eval($field->default);
            }
            // $this->default     = (isset($field->default))      ? $field->default       : null;
            $this->description = (isset($field->description))  ? $field->description   : null;
            $this->mysql["index"]       = (isset($field->index))        ? $field->index         : false;
            $this->mysql["required"]    = (isset($field->required))     ? $field->required      : false;
            $this->mysql["unique"]      = (isset($field->unique))       ? $field->unique        : false;
            switch($this->type){
                case "string":
                    $this->filter["lowercase"]   = (isset($field->lowercase)) ? $field->lowercase    : false;
                    $this->filter["uppercase"]   = (isset($field->uppercase)) ? $field->uppercase    : false;
                    $this->filter["trim"]        = (isset($field->trim))      ? $field->trim         : false;
                    $this->filter["match"]       = (isset($field->match))     ? $field->match        : false;
                    $this->filter["minlength"]   = (isset($field->minlength)) ? $field->minlength    : false;
                    $this->filter["maxlength"]   = (isset($field->maxlength)) ? $field->maxlength    : false;
                    break;
                case "number":
                case "date":
                    $this->filter["min"]        = (isset($field->min))      ? $field->min         : false;
                    $this->filter["max"]        = (isset($field->max))      ? $field->max         : false;
                    break;
            }
    
            $this->_mysql = "TEXT";
            switch($this->type){
                case "string":
                    $this->_mysql = "TEXT";
                    break;
                case "boolean":
                    $this->_mysql = "BOOLEAN";    
                    break;
                case "date":
                    $this->_mysql = "DATE";    
                    break;
                case "number":
                    $this->_mysql = "FLOAT"; 
                    break;
                case "array":
                case "text":
                    $this->_mysql = "BLOB"; 
                    break;
            }
            $this->_mysql .= ($this->mysql["required"])  ? " NOT NULL"           : '';
            $this->_mysql .= ($this->mysql["unique"])    ? ", UNIQUE (`".$this->name."`) "  : '';
            return $this;
    }
    function set($value){
        $this->value = $this->filter($value);
    }
    function filter($value){
        // echo $this->type." ".gettype($value)." <hr>";
        switch($this->type){
            case "string":
                break;
            case "boolean":
                break;
            case "date":
                break;
            case "number":
                break;
            case "array":
                break;
        }
        return $value;
    }
    /**
     * Return the field type
     *
     * @param [object] $field
     * @return void
     */
    function fieldType($field){
        return (gettype($field) == "object") ? $field->type : gettype($field);
    }
}