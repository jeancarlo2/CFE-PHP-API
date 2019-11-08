<?php

class lista{
    private static $db;
    public static function init(){
        self::$db = new wuuModel("Lista", json_decode( file_get_contents(__DIR__.'/../schemas/lista.json') ));
    }
    public static function delete($id){
        self::init();
        return self::$db->remove($id);
    }
    public static function create($id, $arr, $init=0){
        self::init();
        self::$db
            ->set("userid", $id)
            ->set("titulo", $arr["titulo"]);
        return self::$db->save();
    }
    public static function getByID($id){
        self::init();
        self::$db->where([
            ["_id",  "=", $id],
        ]);
        $lista = self::$db->find();
        $lista["itens"] = item::getByListaID($lista["_id"]);
        foreach($lista["itens"] as $k => $it) $lista["itens"][$k]["pago"] = lancamento::getItem($it["_id"]);
        return $lista;
    }
    public static function getByUserID($id, $limit){
        self::init();
        self::$db
            ->where([
                ["userid",  "=", $id],
            ])
            ->by('_id')
            ->order("DESC");
        if($limit) self::$db->limit($limit);
        $listas = self::$db->findAll();
        return $listas;
    }
}