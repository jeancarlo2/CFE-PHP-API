<?php

Flight::route('/conta/@userid/@mes/@ano(/@limit)', function($userid, $mes, $ano, $limit){
    json(conta::getByUserID($userid, $mes, $ano, $limit));
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