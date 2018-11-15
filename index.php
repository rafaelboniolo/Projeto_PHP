<?php
    require_once (realpath(dirname(__FILE__) ). "\\Controller\\ControllerConfig\\routes\\Router.php");
    require_once (realpath(dirname(__FILE__) ). "\\Controller\\ControllerConfig\\JsonController.php");
    require_once (realpath(dirname(__FILE__) ). "\\Controller\\ControllerConfig\\SessionController.php");
    require_once (realpath(dirname(__FILE__) ). "\\Controller\\ControllerConfig\\AuthController.php");
    
    $app = new Router();

     
    $auth = AuthController::monitorAcess(file_get_contents('php://input'));

    
    // $app->route('/insert', function(){
        
    //     $json = file_get_contents('php://input'); // json de entrada
    
    //     $class = JsonController::json_class($json);

    //     $class->insert();

    //     $json = JsonController::class_json($class);

    //     print_r($class);

    //     // $resultado = json_decode($json,true); // conversão do json para array associativo
    //     // print_r($resultado);

    //     // http_response_code(404); // status de retorno da requisição

    // });

    // $app->route('/update', function(){ // rota para acessar dados
        
    // });

    // $app->route('/delete', function(){

    // });

    // $app->route('/findbyid', function(){

    // });

    // $app->route('/findbyatribute', function(){

    // });

    // $app->route('/findall', function(){

    // });


    $app->route('/login', function(){

        $json = file_get_contents('php://input'); 
        // extrair dados do json

        if(!isset($json)){
            print_r(Array('error'=>'no token provider'));
            http_response_code(400);
        }

        $sessionData = AuthController::authenticate($login, $password);

        if(!isset($sessionData)){
            print_r(json_encode(Array('error'=>'login ou senha invalida')));
            http_response_code(404);
        }

        SessionController::open($sessionData);

        print_r(json_encode(Array('token'=>$sessionData['token'], 'tipo'=>$sessionData['user']->getTipo())));
    });

    $app->route('/logout', function(){

        $json = file_get_contents('php://input'); 

        $token = JsonController::extractToken($json);

        SessionController::close($token);
    });

    
    $app->route('/update', function(){ // rota para acessar dados
        $json = file_get_contents('php://input'); 
        print_r($json); 
        http_response_code(200);
    });

    
    $app->run($auth);

    ?>