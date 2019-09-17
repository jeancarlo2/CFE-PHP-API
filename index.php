<?php
header("Access-Control-Allow-Origin: *");
require_once 'flight/Flight.php';
require_once 'wuuDB/autoload.php';
wuuDB::mysql();
wuuDB::setDatabase("cfe");
require_once 'usuario.class.php';

Flight::route('/', function(){
    echo 'hello world!';
});

Flight::route('/user/register', function(){
    json(usuario::register($_REQUEST));
});
Flight::route('/user/login', function(){
    json(usuario::login($_REQUEST));
});
Flight::route('/user/check-email/@email', function($email){
    json(usuario::checkEmail($email));
});

function json($json){
    @header('Content-type: application/json');
    echo json_encode($json,JSON_PRETTY_PRINT);
    die;
}

Flight::start();
