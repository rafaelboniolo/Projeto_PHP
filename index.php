<?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\routes\\Router.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\Facade\\FacadeRoutes.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\AuthController.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\JsonController.php");
    
    $app = new Router();

    //$hasJson = JsonController::hasJson(file_get_contents('php://input'));
    //if(!$hasJson) return;

    //$isLogado = AuthController::monitorAcess(file_get_contents('php://input'));
    //if(!$isLogado) http_response_code(401);

    
    $app->route('/insert', function(){
        FacadeRoutes::insert(file_get_contents('php://input'));
    });

    $app->route('/update', function(){ 
        FacadeRoutes::update(file_get_contents('php://input'));        
    });

    $app->route('/delete', function(){
        FacadeRoutes::delete(file_get_contents('php://input'));
    });

    $app->route('/findbyid', function(){
        FacadeRoutes::findById(file_get_contents('php://input'));
    });

    $app->route('/findbyatributes', function(){
        FacadeRoutes::findByAtributes(file_get_contents('php://input'));
    });

    $app->route('/findall', function(){
        FacadeRoutes::findAll(file_get_contents('php://input'));
    });

    $app->route('/login', function(){
        FacadeRoutes::login(file_get_contents('php://input'));
    });

    $app->route('/logout', function(){
        FacadeRoutes::logout(file_get_contents('php://input'));
    });

    
    $app->run(true);

    ?>