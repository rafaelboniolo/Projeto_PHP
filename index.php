<?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\routes\\Router.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\Facade\\FacadeRoutes.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\AuthController.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\JsonController.php");
    
    $app = new Router();

    $hasJson = JsonController::hasJson(file_get_contents('php://input'));
    if(!$hasJson) return;

    $isLogado = AuthController::monitorAcess(file_get_contents('php://input'));
    if(!$isLogado) http_response_code(401);

    
    $app->route('/insert', function(){
        
        $json = file_get_contents('php://input'); // json de entrada
    
        $class = JsonController::json_class($json);

        $class->insert();

        $json = JsonController::class_json($class);

        print_r($class);

        // $resultado = json_decode($json,true); // conversão do json para array associativo
        // print_r($resultado);

        // http_response_code(404); // status de retorno da requisição

    });

    $app->route('/update', function(){ // rota para acessar dados
        
    });

    $app->route('/delete', function(){

    });

    $app->route('/findbyid', function(){

    });

    $app->route('/findbyatribute', function(){

    });

    $app->route('/findall', function(){

    });


    $app->route('/login', function(){
        FacadeRoutes::login(file_get_contents('php://input'));
    });

    $app->route('/logout', function(){
        FacadeRoutes::logout(file_get_contents('php://input'));
    });

    
    $app->route('/update', function(){ // rota para acessar dados
        $json = file_get_contents('php://input'); 
        print_r($json); 
        http_response_code(200);
    });

    
    $app->run($isLogado);

    ?>