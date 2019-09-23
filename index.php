<?php
include_once "config.php";

Flight::route('/', function(){ });

include_once "routes/usuario.php"; #Rotas do usuário
include_once "routes/lancamentos.php"; #Rotas para lançamentos

Flight::start();
