<?php

class lancamento{
    private static $db;
    public static function init(){
        self::$db = new wuuModel("Lancamento", json_decode( file_get_contents(__DIR__.'/../schemas/lancamento.json') ));
    }
    public static function getByUserID($id, $mes, $ano){
        self::init();
        self::$db
            ->where([
                ["userid", "=", $id],
                ["mes", "=", $mes],
                ["ano", "=", $ano]
            ]);
        return self::$db->findAll();
    }
    public static function delete($id){
        self::init();
        return self::$db->remove($id);
    }
    public static function create($id, $arr){
        self::init();
        self::$db
            ->set("userid", $id)
            ->set("titulo", $arr["titulo"])
            ->set("tipo",   $arr["tipo"])
            ->set("valor",  $arr["valor"])
            ->set("conta",  $arr["conta"]);
        return self::$db->save();
    }
}