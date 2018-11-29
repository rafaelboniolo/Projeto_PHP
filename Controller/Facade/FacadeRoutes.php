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


    // facade é um padrao de projeto que oculta complexidade
    // apenas deixa o index.php limpo e facil de ler
    class FacadeRoutes{

        public static function login($json){
            
            $user = json_decode($json,true)["dados"]["1"];


            $sessionData = AuthController::authenticate($user['login'], $user['password']);    
        
             if($sessionData['token']==''){
                print_r(json_encode(Array('error'=>'login ou senha invalida')));
                http_response_code(400);
             }
    
            http_response_code(200);

           // SessionController::open($sessionData);
    
            print_r(json_encode(Array('token'=>$sessionData['token'], 'user'=>$sessionData['user'])));
        }

        public static function logout($json){
            $token = JsonController::extractToken($json);
            SessionController::close($token);
        } 

        public static function insert($json){
           
            $class = JsonController::json_class($json);

            $class->insert();

            if($class->myId()!=""){
                http_response_code(200);
                print_r(JsonController::class_json($class));
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
               $arrayDados[$i] = JsonController::class_json($dados);
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

            $i=1;
            foreach ($res['data'] as $dados) {
               $arrayDados[$i] = JsonController::class_json($dados);
                $i++;
            }

            print_r(json_encode(Array("config"=>JsonController::getConfig($class, $i),"dados"=>$arrayDados)));
        }

        public static function selectUser($json){
            $class = JsonController::json_class($json, true);
            $res = $class->find();

            if($res['rows'] == 0){
                http_response_code(404);
                return;
            }


            $i=1;
            
            if($res->getTipo() == 'ADM'){
                
                $reflectionClass = new ReflectionClass("Administrador"); // encontrar a classe via Reflection
                $class = $reflectionClass->newInstance(new stdClass());
                $class->setId_pessoa($res->getId_pessoa());

            }else if($res->getTipo() == 'INV'){
                
                $reflectionClass = new ReflectionClass("Investidor"); // encontrar a classe via Reflection
                $class = $reflectionClass->newInstance(new stdClass());
                $class->setId_pessoa($res->getId_pessoa());

            }else if($res->getTipo() == 'GES'){

                $reflectionClass = new ReflectionClass("Gestor"); // encontrar a classe via Reflection
                $class = $reflectionClass->newInstance(new stdClass());
                $class->setId_pessoa($res->getId_pessoa());

            }

            $class->findById();



            print_r(json_encode(Array("config"=>JsonController::getConfig($class, $i),"dados"=>$class)));
        }
        

    }
?>