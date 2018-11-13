<?php
    require_once (realpath('Controller/routes/Router.php'));
    
    $app = new Router();


    $app->route('/insert', function(){
        $json = file_get_contents('php://input'); // json de entrada
        print_r($json);

        $resultado = json_decode($json,true); // conversão do json para array associativo
        print_r($resultado);

        http_response_code(404); // status de retorno da requisição

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

    $app->route('/retornaGraficos', function(){


    
        $json['class'] = "Pessoa";
        $json['nome']="Rafael";
        $json['cpf']="673254";
        
        
        $json1 = json_encode($json); // transformar array associativo para json
        print_r($json1);
    });

    


    $app->run();

    ?>