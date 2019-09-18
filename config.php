<?php
header("Access-Control-Allow-Origin: *");
require_once 'flight/Flight.php';
require_once 'wuuDB/autoload.php';
wuuDB::mysql("localhost","appc_db","appc_db");
wuuDB::setDatabase("cfe");
/**
 * Controladores
 */
require_once 'controllers/usuario.class.php';
/**
 * Funções
 */
function json($json){
    @header('Content-type: application/json');
    echo json_encode($json,JSON_PRETTY_PRINT);
    die;
}