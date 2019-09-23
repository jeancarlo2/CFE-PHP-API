<?php
/**
 * Rotas para o controlador usuario.class.php
 */
Flight::route('/lancamento/@userid/@mes/@ano', function($userid, $mes, $ano){
    json(lancamento::getByUserID($userid, $mes, $ano));
});

Flight::route('/lancamento/create/@userid', function($userid){
    json(lancamento::create($userid, $_REQUEST));
});

Flight::route('/lancamento/delete/@id', function($id){
    json(lancamento::delete($id));
});