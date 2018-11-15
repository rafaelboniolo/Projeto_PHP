<?php
   
    require_once (realpath('Model\\vo\\Pessoa.php'));
    require_once (realpath("Controller\\ControllerConfig\\AuthController.php"));
    
    class SessionController{


        public static function open($sessionData){
            session_start();
            $_SESSION[$sessionData['token']] = serialize($sessionData['user']); 
        }

        public static function close($token){
            session_start();
            if(!isset($_SESSION[$token]))
                return;
                
            session_unset($_SESSION[$token]);
        }

        public static function validateSession($token){
            session_start();
            if(isset($_SESSION[$token]))
                return true;
            return false;
        }



    }

?>