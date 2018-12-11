<?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    if(!PROTECTED_PROJECT::ANALYZE()) return;

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\PessoaController.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Pessoa.php");
        

    class AuthController{

        public static function authenticate($login, $password){
            
            $user = PessoaController::authenticate($login, $password);
            
            if(!isset($user) || !$user)
                return false;
            
            $token = AuthController::tokenGenerate(json_encode(JsonController::class_json($user)[0]));

            return Array('token' => $token, 
                        'user' => Array(
                                    "id_pessoa"=>$user->getId_Pessoa(),
                                    "nome"=>$user->getNome(),
                                    "tipo"=>$user->getTipo()));
        }

        private static function tokenGenerate($componentToken){
            return base64_encode($componentToken);
        }

    }

?>