<?php
//header("Access-Control-Allow-Origin:  {$_SERVER['HTTP_ORIGIN']}");
//header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Headers: *");
//header("Access-Control-Allow-Methods: PUT, GET, POST");

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    if(!PROTECTED_PROJECT::ANALYZE()) return;

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\JsonController.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\SessionController.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\AuthController.php");

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\TransacaoController.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\AcaoController.php");


    // facade é um padrao de projeto que oculta complexidade
    // apenas deixa o index.php limpo e facil de ler
    class FacadeRoutes{

        public static function login($json){

            $user = json_decode($json,true)["dados"][0];
            $sessionData = AuthController::authenticate($user['login'], $user['password']);    
        
             if($sessionData['token']==''){
                print_r(json_encode(Array('error'=>'login ou senha invalida')));
                http_response_code(400);
             }
    
            http_response_code(200);

            //SessionController::open($sessionData);
    
            print_r(json_encode(Array('token'=>$sessionData['token'], 'user'=>$sessionData['user'])));
        }

        public static function logout($json){
            $token = JsonController::extractToken($json);
            SessionController::close($token);
        } 

        public static function insert($json){
           
            $class = JsonController::json_class($json);

            $class[0]->insert();
            
            if($class[0]->myId()!=""){
                http_response_code(200);
                print_r(json_encode(Array("config"=>JsonController::getConfig($class[0]),"dados"=>JsonController::class_json($class)))); //forma correta
            }else{
                http_response_code(400);
                print_r(json_encode(Array("error"=>"insert error")));
            }
        }

        public static function update($json){
            $class = JsonController::json_class($json,true);
            $class->update();

            http_response_code(200);
            //print_r(JsonController::class_json($class));
        }
        
        public static function delete($json){
            $class = JsonController::json_class($json, true);
            $class->delete();
        }
        
        public static function findById($json){
            $class = JsonController::json_class($json, true);
            $class->findById();

            print_r(json_encode(Array("config"=>JsonController::getConfig(),"dados"=>JsonController::class_json($class))));
            http_response_code(200);
            
        }

        public static function findByAtributes($json){
            $class = JsonController::json_class($json, true);
            $res = $class->findByAtributes();



            if($res['rows'] == 0){
                http_response_code(404);
                return;
            }

            $arrayDados = Array();

            $i=1;
            foreach ($res['data'] as $dados) {
               $arrayDados[$i] = JsonController::class_json($dados, 0);
                $i++;
            }

            print_r(json_encode(Array("config"=>JsonController::getConfig($class, $i),"dados"=>$arrayDados)));
        }
        
        public static function findAll($json){
            $class = JsonController::json_class($json, true);
            $res = $class->findAll();

            if($res['rows'] == 0){
                http_response_code(404);
                return;
            }

            $arrayDados = Array();

            $i=0;
            foreach ($res['data'] as $dados) {
               $arrayDados[$i] = JsonController::class_json($dados);
                $i++;
            }

            print_r(json_encode(Array("config"=>JsonController::getConfig($class, $i),"dados"=>$arrayDados)));
        }

        
        public static function sacar($json){
            $transacao = JsonController::json_class($json, true);
            $transacao->find();
            TransacaoController::sacar($transacao);
        }

        public static function saquesDisponiveis($json){
            $class = JsonController::json_class($json, true);
            $res = TransacaoController::saquesDisponiveis($json);
            
            if($res['rows'] == 0){
                http_response_code(200);
                return;
            }

            if($res['rows'] == 1){
               $dados = JsonController::class_json($res['data']);
               print_r(json_encode(Array("config"=>JsonController::getConfig($class),"dados"=>$dados)));
               return;
            }

            $arrayDados= JsonController::class_json($res['data']);

            print_r(json_encode(Array("config"=>JsonController::getConfig($class[0], $res['rows']),"dados"=>$arrayDados)));

        }

        

        public static function depositar($json){
            $class = JsonController::getClassFromJson($json);
            $res = TransacaoController::depositar($json);
            print_r(json_encode(Array("config"=>JsonController::getConfig($class),"dados"=>$res)));

        }


        public static function comprarAcao($json){
            $acao = AcaoController::comprarAcao($json);
            $class = JsonController::getClassFromJson($json);
            print_r(json_encode(Array("config"=>JsonController::getConfig($class),"dados"=>$acao)));
        }





        public static function listarMinhasAcoes($json){
            $class = JsonController::json_class($json, true);
            $acao = AcaoController::listarMinhasAcoes($json);
            print_r(json_encode(Array("config"=>JsonController::getConfig($class),"dados"=>$acao)));
        }

        public static function venderAcao($json){
            $class = JsonController::json_class($json, true);
            $acao = AcaoController::venderAcao($json);
            print_r(json_encode(Array("config"=>JsonController::getConfig($class),"dados"=>$acao)));
        }


        

    }
?>