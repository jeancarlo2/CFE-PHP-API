<?php
include_once "config.php";

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

Flight::start();
