<?php
header("Access-Control-Allow-Origin: *");
require_once 'flight/Flight.php';
require_once 'wuuDB/autoload.php';

/**
 * true para habilitar banco de dados localhost para desenvolvimento
 */
if(false){
    wuuDB::mysql();
    wuuDB::setDatabase("cfe");
}else{
    wuuDB::mysql("127.0.0.1","appc_db","appc_db");
    wuuDB::setDatabase("appc_db");
}

/**
 * Controladores
 */
require_once 'controllers/usuario.class.php';
require_once 'controllers/lancamento.class.php';
require_once 'controllers/conta.class.php';
require_once 'controllers/meta.class.php';
require_once 'controllers/lista.class.php';
require_once 'controllers/item.class.php';
/**
 * Funções
 */
function json($json){
    @header('Content-type: application/json');
    echo json_encode($json,JSON_PRETTY_PRINT);
    die;
}