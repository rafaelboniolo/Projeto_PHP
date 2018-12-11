<?php
   
    // header("Access-Control-Allow-Origin:  {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: PUT, GET, POST");

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\routes\\Router.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\Facade\\FacadeRoutes.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\AuthController.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\JsonController.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\TransacaoController.php");
    $app = new Router();

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

    $app->route('/sacar', function(){
        FacadeRoutes::sacar(file_get_contents('php://input'));
    });

    $app->route('/findsaquesdisponiveis', function(){
        FacadeRoutes::saquesDisponiveis(file_get_contents('php://input'));
    });
    
    $app->route('/depositar', function(){
        FacadeRoutes::depositar(file_get_contents('php://input'));
    });
    
    $app->route('/compraracao', function(){
        FacadeRoutes::compraracao(file_get_contents('php://input'));
    });
    
    $app->route('/listarminhasacoes', function(){
        FacadeRoutes::listarminhasacoes(file_get_contents('php://input'));
    });

    $app->route('/venderacoes', function(){
        FacadeRoutes::venderAcoes(file_get_contents('php://input'));
    });

    $app->route('/fundodisponivel', function(){
        FacadeRoutes::fundoDisponivel(file_get_contents('php://input'));
    });
    
    $app->route('/ganhostotais', function(){
        FacadeRoutes::ganhosTotais(file_get_contents('php://input'));
    });
    
    $app->route('/dadosgestor', function(){
        FacadeRoutes::dadosGestor(file_get_contents('php://input'));
    });
    
    $app->route('/logout', function(){
        FacadeRoutes::logout(file_get_contents('php://input'));
    });

    
    $app->run(true);

    ?>