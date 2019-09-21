<?php

class lancamento{
    private static $db;
    public static function init(){
        self::$db = new wuuModel("Lancamento", json_decode( file_get_contents(__DIR__.'/../schemas/lancamento.json') ));
    }
    public static function getByUserID($id){
        self::init();
    }
}