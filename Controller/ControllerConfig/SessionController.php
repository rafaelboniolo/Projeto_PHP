<?php

    // depreciado

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    if(!PROTECTED_PROJECT::ANALYZE()) return;
   
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Pessoa.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\AuthController.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\JsonController.php");
    
    class SessionController{


        //inicia uma sessao com os dados do usuario que foi autenticado
        public static function open($sessionData){
            session_start();
            $_SESSION[$sessionData['token']] = serialize($sessionData['user']); 

            //print_r($_SESSION[$sessionData['token']]);
        }

        //fecha a sessao do usuario com o token informado
        public static function close($token){
            session_start();
            if(!isset($_SESSION[$token]))
                return;
                
            unset($_SESSION[$token]);
        }

        //valida se existe o token na sessao
        public static function validateSession($token){

            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            
            foreach (explode('/', $uri) as $key => $value) {
                if($value == 'login')
                    return true;
            }
    
            if(!isset($token)) return false;

            session_start();
            
            if(isset($_SESSION[$token]))
                return true;
            return false;
        }

        public static function restoreUserByToken($json){
            $token = JsonController::extractToken($json);
           
             return unserialize($_SESSION[$token]);
        }



    }

?>