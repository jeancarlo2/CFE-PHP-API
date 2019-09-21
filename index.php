<?php
include_once "config.php";

Flight::route('/', function(){

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

Flight::route('/lancamento/@userid/@mes/@ano', function($userid, $mes, $ano){
    json(lancamento::getByUserID($userid, $mes, $ano));
});

Flight::route('/lancamento/create/@userid', function($userid){
    json(lancamento::create($userid, $_REQUEST));
});

Flight::start();
