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

    }
?>