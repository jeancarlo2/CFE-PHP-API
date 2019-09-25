<?php

Flight::route('/meta/@userid', function($userid){
    json(meta::getByUserID($userid));
});

Flight::route('/meta/delete/@id', function($id){
    json(meta::delete($id));
});

Flight::route('/meta/pagar/@userid', function($userid){
    json(lancamento::create($userid, $_REQUEST));
});

Flight::route('/meta/create/@userid', function($userid){
    json(meta::create($userid, $_REQUEST));
});