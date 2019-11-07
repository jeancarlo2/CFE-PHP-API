<?php

class item{
    private static $db;
    public static function init(){
        self::$db = new wuuModel("Item", json_decode( file_get_contents(__DIR__.'/../schemas/item.json') ));
    }
    public static function delete($id){
        self::init();
        return self::$db->remove($id);
    }
    public static function create($id, $arr){
        self::init();
        self::$db
            ->set("listaid", $id)
            ->set("valor", $arr["valor"])
            ->set("titulo", $arr["titulo"]);
        return self::$db->save();
    }
    public static function getByID($id){
        self::init();
        self::$db->where([
            ["_id",  "=", $id],
        ]);
        $lista = self::$db->find();
        return $lista;
    }
    public static function getByListaID($id, $limit){
        self::init();
        self::$db
            ->where([
                ["listaid",  "=", $id],
            ])
            ->by('_id')
            ->order("DESC");
        if($limit) self::$db->limit($limit);
        $listas = self::$db->findAll();
        return $listas;
    }
}