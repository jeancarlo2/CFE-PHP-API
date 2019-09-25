<?php

class meta{
    private static $db;
    public static function init(){
        self::$db = new wuuModel("Meta", json_decode( file_get_contents(__DIR__.'/../schemas/meta.json') ));
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
            ->set("valor",  $arr["valor"]);
        return self::$db->save();
    }
    public static function getByUserID($id){
        self::init();
        self::$db
            ->where([
                ["userid",  "=", $id],
            ])
            ->by('_id')
            ->order("DESC");
        $metas = self::$db->findAll();
        foreach($metas as $k => $meta) $metas[$k]["pago"] = lancamento::getMeta($meta["_id"]);
        return $metas;
    }
}