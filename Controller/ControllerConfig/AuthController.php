<?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    if(!PROTECTED_PROJECT::ANALYZE()) return;

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\PessoaController.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Pessoa.php");
        

    class AuthController{

        // retorna false ou o token de autenticação
        // recebe o login e a senha do usuario
        // retorna um array com o token e o usuario
        // se nao houver usuario com este login e senha, retorna falso
        public static function authenticate($login, $password){

            
            $user = PessoaController::authenticate($login, $password);

            
            if(!isset($user) || !$user)
                return false;
            
                
           
            $token = AuthController::tokenGenerate(json_encode(JsonController::class_json($user)[0]));
            

            return Array('token' => $token, 
                        'user' => Array(
                                    "id_pessoa"=>$user->getId_Pessoa(),
                                    "nome"=>$user->getNome(),
                                    "cpf"=>$user->getNome()));
        }

        
        private static function tokenGenerate($componentToken){
            return base64_encode($componentToken);
        }

        // // usado para controlar a sessao e monitorar os acessos, 
        // // todo json, passará por este filtro
        // // se existir o token na sessao, retorna true, senao false
        // // valida se existe json na request
        // public static function monitorAcess($json){
        //     $token = JsonController::extractToken($json);
        //     return SessionController::validateSession($token);
        // }
    }

?>