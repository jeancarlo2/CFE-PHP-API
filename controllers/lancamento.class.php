<?php

class lancamento{
    private static $db;
    public static function init(){
        self::$db = new wuuModel("Lancamento", json_decode( file_get_contents(__DIR__.'/../schemas/lancamento.json') ));
    }
    public static function getByUserID($id){
        self::init();
    }
    public static function create($id, $arr){
        self::init();
        self::$db
            ->set("userid", $id)
            ->set("tipo",   $arr["tipo"])
            ->set("valor",  $arr["valor"])
            ->set("conta",  $arr["conta"]);
        return self::$db->save();
    }
}