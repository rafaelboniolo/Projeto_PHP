<?php
    require_once (realpath('Controller/routes/Router.php'));
    
    $app = new Router();

    $app->route('/insert', function($json){
        echo $json;
    });

    $app->route('/update', function(){

    });

    $app->route('/delete', function(){

    });

    $app->route('/findbyid', function(){

    });

    $app->route('/findbyatribute', function(){

    });

    $app->route('/findall', function(){

    });


    $app->run();

    ?>