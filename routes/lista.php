<?php

Flight::route('/lista/delete/@id', function($id){
    json(lista::delete($id));
});

Flight::route('/lista/create/@userid', function($userid){
    json(lista::create($userid, $_REQUEST));
});

Flight::route('/lista/get/@id', function($id){
    json(lista::getByID($id));
});

Flight::route('/lista/@userid(/@limit)', function($userid, $limit){
    json(lista::getByUserID($userid, $limit));
});
