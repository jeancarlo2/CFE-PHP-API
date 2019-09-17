<?php
class wuuModel extends wuuCRUD{
    private $name; # Table Name
    private $model;
    public function __construct($name, $schema){
        $schema = new wuuSchema($schema);
        $name = strtolower($name);
        wuuDB::setTable($name, $schema->mysql());
        parent::__construct($name); #Initialize CRUD
        $this->name = $name;
        $this->model = $schema->fields();
    }
    public function set($key, $value){
        $this->model->{$key}->set($value);
        return $this;
    }
    public function get($key){
        return $this->model->{$key}->{"value"};
    }
    /**
     * Reset all model fields
     *
     * @return void
     */
    public function reset(){
        foreach( $this->model as $key => $field ){
            $this->model->{$key}->value = null;
        }
    }
    /**
     * Render model object
     *
     * @param boolean $new define if render will include default values and config some mysql fields
     * @return void
     */
    public function render($new =  false){
        $render = (object)[];
        foreach( $this->model as $key => $field ){
            $render->{$key} = ($field->value)? $field->value : 
                (($new) ? null : $field->default);
            if( $field->mysql["required"]    && !$render->{$key} && !$new) throw new Exception("The $field->name field is required");
            if( $field->mysql["unique"]      && $this->where([ [$field->name,"=",$render->{$key}] ])->find()) throw new Exception("The $field->name field must be unique");
            if( !$render->{$key} ) unset($render->{$key});
        }
        return $render;
    }
    /**
     * 
     * END POINTS
     *
     */
    public function save($_id=0){
        if($_id) {
            $this->_id = $_id;
            return $this->U($this->render($_id));
        }
        $result = $this->C($this->render());
        #$this->modelReset();
        return $result;
    }
    public function remove($_id=0){
        $this->_id = $_id;
        return $this->D();
    }
    public function findAll(){
        return $this->R();
    }
    public function find(){
        $result = $this
        ->limit(1)
        ->R();
        return (isset($result[0])? $result[0] : $result);
    }
}