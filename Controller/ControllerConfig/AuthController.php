<?php

    require_once (realpath("Controller\\PessoaController.php"));
    require_once (realpath('Model\\vo\\Pessoa.php'));
        

    class AuthController{

        // retorna false ou o token de autenticação
        public static function authenticate($login, $password){

            // retorna um componente utilizado no token ou false
            $user = PessoaController::authenticate($login, $password);

            if(!isset($user) || $user->getId_pessoa()=="")
                return false;

                $token = AuthController::tokenGenerate($user->getCpf());

                return Array('token' => $token, 'user' => $user);
        }

        private static function tokenGenerate($componentToken){
            
            //formula matematica para gerar o token
            return $componentToken;

        }

        public static function monitorAcess($json){
            $token = JsonController::extractToken($json);
            return SessionController::validateSession($token);

        }
    }

?>