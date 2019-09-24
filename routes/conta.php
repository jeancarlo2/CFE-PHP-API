<?php

Flight::route('/conta/@userid/@mes/@ano', function($userid, $mes, $ano){
    json(conta::getByUserID($userid, $mes, $ano));
});

Flight::route('/conta/delete/@id', function($id){
    json(conta::delete($id));
});

Flight::route('/conta/pagar/@userid', function($userid){
    json(lancamento::create($userid, $_REQUEST));
});

Flight::route('/conta/create/@userid', function($userid){
    json(conta::create($userid, $_REQUEST));
});