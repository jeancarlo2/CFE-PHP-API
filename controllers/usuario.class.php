<?php

class usuario{
    private static $db;
    private static function init(){
        self::$db = new wuuModel("Usuarios", json_decode( file_get_contents(__DIR__.'/../schemas/usuario.json') ));
    }
    public static function register($arr){
        self::init();
        self::$db
            ->set("nome",   $arr["nome"])
            ->set("senha",  $arr["senha"])
            ->set("email",  $arr["email"]);
        return self::$db->save();
    }
    public function login($arr){
        self::init();
        self::$db
            ->where([
                ["email","=",$arr["email"]],
                ["senha","=",$arr["senha"]]
            ]);
        return self::$db->find();
    }
    public function delete($id){
        self::init();
        return self::$db->remove($id);
    }
    public static function checkEmail($email){
        self::init();
        self::$db
            ->selectFields(['email'])
            ->where([
                ["email","=",$email]
            ]);
        return self::$db->findAll();
    }
}