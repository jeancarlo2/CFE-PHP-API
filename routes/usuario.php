<?php
/**
 * Rotas para o controlador usuario.class.php
 */
Flight::route('/usuario/register', function(){ #Rota de registo
    json(usuario::register($_REQUEST));
});

Flight::route('/usuario/login', function(){ #Rota de autenticações
    json(usuario::login($_REQUEST));
});

Flight::route('/usuario/delete/@id', function($id){ #Rota de autenticações
    json(usuario::delete($id));
});

Flight::route('/usuario/check-email/@email', function($email){ #Rota de verificação de email para cadastro
    json(usuario::checkEmail($email));
});