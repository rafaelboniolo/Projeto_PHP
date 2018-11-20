<?php
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
    
            $sessionData = AuthController::authenticate($user['login'], $user['senha']);
    
            if(!isset($sessionData)){
                print_r(json_encode(Array('error'=>'login ou senha invalida')));
                http_response_code(404);
            }
    
            SessionController::open($sessionData);
    
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
                //print_r(JsonController::class_json($class));
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

            print_r($class);
        }

        public static function findByAtributes($json){
            $class = JsonController::json_class($json, true);
            $class->findByAtributes();

            print_r($class);
        }
        
        public static function findAll($json){
            $class = JsonController::json_class($json, true);
            $class=$class->findAll();
            print_r($class);
        }
        

    }
?>