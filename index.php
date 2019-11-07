<?php
include_once "config.php";

Flight::route('/', function(){ if(is_file("index.html")) include_once "index.html";  });

include_once "routes/usuario.php";      #Rotas do usuário
include_once "routes/lancamento.php";   #Rotas para lançamentos
include_once "routes/conta.php";        #Rotas para contas
include_once "routes/meta.php";         #Rotas para metas
include_once "routes/lista.php";        #Rotas para listas
include_once "routes/item.php";         #Rotas para itens

Flight::start();
