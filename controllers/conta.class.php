<?php

class conta{
    private static $db;
    public static function init(){
        self::$db = new wuuModel("Conta", json_decode( file_get_contents(__DIR__.'/../schemas/conta.json') ));
    }
    public static function getByUserID($id, $mes, $ano){
        self::init();
        self::$db
            ->where([
                ["userid",  "=", $id],
                ["tipo",    "IS NULL", ""],
            ])
            ->by('_id')
            ->order("DESC");
        $contasFixas = self::$db->findAll();
        self::$db->reset();
        self::$db
            ->where([
                ["userid",  "=", $id],
                ["",  "( `expano` >= '{$ano}' OR `expano` = '{$ano}' AND `expmes` >= '{$mes}')", ""],
                ["tipo",    "IS NOT NULL", ""],
            ])
            ->by('_id')
            ->order("DESC");
        $contasParceladas = self::$db->findAll();
        return [ 
            "parceladas" => $contasParceladas,
            "fixas" => $contasFixas
        ];
    }
    public static function create($id, $arr, $init=0){
        self::init();
        self::$db
            ->set("userid", $id)
            ->set("titulo", $arr["titulo"])
            ->set("tipo",   $arr["tipo"])
            ->set("valor",  $arr["valor"]);
        if(isset($arr["parcelas"])) self::$db->set("parcelas",  $arr["parcelas"]);
        if(isset($arr["parcelas"])) self::$db->set("expmes",  date('m', strtotime("+{$arr['parcelas']} month", strtotime(date('Y-m-d')))));
        if(isset($arr["parcelas"])) self::$db->set("expano",  date('Y', strtotime("+{$arr['parcelas']} month", strtotime(date('Y-m-d')))));
        return self::$db->save();
    }
}