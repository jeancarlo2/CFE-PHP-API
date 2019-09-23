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
                ["userid",  "=", $id],
                ["mes",     "=", $mes],
                ["ano",     "=", $ano],
                ["init",    "IS NULL", ""],

            ])
            ->by('_id')
            ->order("DESC");
        return self::$db->findAll();
    }
    public static function calcByUserID($id, $mes, $ano){
        self::init();
        self::$db
            ->where([
                ["userid",  "=", $id],
                ["mes",     "=", $mes],
                ["ano",     "=", $ano],
                ["init",    "=", "1"],
            ]);
        $init = self::$db->find();
        if(!$init){
            #verificação mes 1
           if($mes == 1){
                $where =[
                        ["userid", "=", $id],
                        ["mes", "=", 12],
                        ["ano", "=", $ano-1],
                ];
           }else{
                $where = [
                    ["userid", "=", $id],
                    ["mes", "=", $mes-1],
                    ["ano", "=", $ano],
                ];
           }
           self::$db->reset();
           self::$db
                ->where($where)
                ->by('_id')
                ->order("ASC");
           #ultimo mes
           $uMes = self::$db->findAll();
           self::$db->reset();
           if(!$uMes){ #se n existe mes, define saldo init como 0
                self::create($id, [
                    "titulo"    => "init",
                    "tipo"      => 1,
                    "valor"     => 0,
                    "conta"     => 0,
                    "mes"       => $mes,
                    "ano"       => $ano,
                ], 1);
           }else{
               $saldo = 0;
               foreach($uMes as $lancamento){
                   echo ($lancamento["tipo"])? "+". $lancamento["valor"] : "-". $lancamento["valor"]."<br>";
                   $saldo = ($lancamento["tipo"])? $saldo + $lancamento["valor"] : $saldo - $lancamento["valor"];
               }
               self::create($id, [
                    "titulo"    => "init",
                    "tipo"      => 1,
                    "valor"     => $saldo,
                    "conta"     => 0,
                    "mes"       => $mes,
                    "ano"       => $ano,
                ], 1);
           }
        }
        self::$db->reset();
        self::$db
            ->where([
                ["userid",  "=", $id],
                ["mes",     "=", $mes],
                ["ano",     "=", $ano],
            ]);
        $lancamentos    = self::$db->findAll();
        $saldo          = 0;
        foreach($lancamentos as $lancamento) @$saldo = ($lancamento["tipo"])? $saldo + $lancamento["valor"] : $saldo - $lancamento["valor"];
        return $saldo;
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
            ->set("valor",  $arr["valor"])
            ->set("init",   $init)
            ->set("conta",  $arr["conta"]);
        if(isset($arr["data"]))    self::$db->set("data",  $arr["data"]);
        if(isset($arr["mes"]))     self::$db->set("mes",   $arr["mes"]);
        if(isset($arr["ano"]))     self::$db->set("ano",   $arr["ano"]);
        return self::$db->save();
    }
}