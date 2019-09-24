<?php

Flight::route('/conta/@userid/@mes/@ano', function($userid, $mes, $ano){
    json(conta::getByUserID($userid, $mes, $ano));
});

Flight::route('/conta/create/@userid', function($userid){
    json(conta::create($userid, $_REQUEST));
});