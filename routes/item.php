<?php

Flight::route('/item/delete/@id', function($id){
    json(item::delete($id));
});

Flight::route('/item/create/@listaid', function($listaid){
    json(item::create($listaid, $_REQUEST));
});

Flight::route('/item/get/@id', function($id){
    json(item::getByID($id));
});

Flight::route('/item/pagar/@userid', function($userid){
    json(lancamento::create($userid, $_REQUEST));
});

Flight::route('/item/@listaid(/@limit)', function($listaid, $limit){
    json(item::getByListaID($listaid, $limit));
});
