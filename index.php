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

    //$hasJson = JsonController::hasJson(file_get_contents('php://input'));
    //if(!$hasJson) return;

    //$isLogado = AuthController::monitorAcess(file_get_contents('php://input'));
    //if(!$isLogado) http_response_code(401);

    // $app->route('/aa', function(){
    //     print_r(json_encode(Array("email"=>"rafael", "password"=>"1234")));
    // });

    
    $app->route('/insert', function(){
        FacadeRoutes::insert(file_get_contents('php://input'));
    });

    $app->route('/selectuser', function(){
        FacadeRoutes::selectUser(file_get_contents('php://input'));
    });

    // $app->route('/update', function(){ 
    //     FacadeRoutes::update(file_get_contents('php://input'));        
    // });

    // $app->route('/delete', function(){
    //     FacadeRoutes::delete(file_get_contents('php://input'));
    // });

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
   $app->route('/aiiim', function(){
      print_r(json_encode(Array("Nome"=>"Gabriel"))); // DO php para o insomnia

      // print_r(file_get_contents('php://input'));   Testar do insomnia para o PHP

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
    
    




    $app->route('/logout', function(){
        FacadeRoutes::logout(file_get_contents('php://input'));
    });

    
    $app->run(true);

    ?>