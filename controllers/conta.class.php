<?php

class conta{
    private static $db;
    public static function init(){
        self::$db = new wuuModel("Conta", json_decode( file_get_contents(__DIR__.'/../schemas/conta.json') ));
    }
    public static function getByUserID($id, $mes, $ano, $limit){
        self::init();
        self::$db
            ->where([
                ["userid",  "=", $id],
                ["", "(`ano` < '{$ano}' OR `ano` = '{$ano}' AND `mes` <= '{$mes}' )",""],
                ["tipo",    "IS NULL", ""],
            ])
            ->by('_id')
            ->order("DESC");
        if($limit) self::$db->limit($limit);
        $contasFixas = self::$db->findAll();
        self::$db->reset();

        foreach($contasFixas as $k => $conta){
            $contasFixas[$k]["pago"] = lancamento::getConta($conta["_id"], $mes, $ano);
        }
        self::$db
            ->where([
                ["userid", "=", $id],
                ["", "(`ano` < '{$ano}' OR `ano` = '{$ano}' AND `mes` <= '{$mes}')",""],
                ["", "(`expano` > '{$ano}' OR `expano` = '{$ano}' AND `expmes` >= '{$mes}')",""],
                ["tipo","IS NOT NULL", ""],
            ])
            ->by('_id')
            ->order("DESC");
        if($limit) self::$db->limit($limit);
        $contasParceladas = self::$db->findAll();
        foreach($contasParceladas as $k => $conta){
            $contasParceladas[$k]["pago"] = lancamento::getConta($conta["_id"], $mes, $ano);
            $contasParceladas[$k]["pagos"] = lancamento::getConta($conta["_id"]);
        }
        return [ 
            "parceladas" => $contasParceladas,
            "fixas" => $contasFixas
        ];
    }
    public static function delete($id){
        self::init();
        return self::$db->remove($id);
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