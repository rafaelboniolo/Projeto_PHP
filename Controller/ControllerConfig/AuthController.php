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
            
            $token = AuthController::tokenGenerate($user->getCpf());
            
            return Array('token' => $token, 
                        'user' => Array(
                                    "id_pessoa"=>$user->getId_Pessoa(),
                                    "nome"=>$user->getNome(),
                                    "cpf"=>$user->getNome()));
        }

        //recebe um componente para gerar token, neste caso o cpf
        // da pra fazer um calculo do cpf com a data atual e a hora, ai geramos um token que expira a cada hora, ou dia, a regra pode ser aplicada depois
        // neste caso, por exempol soh retornamos 1032639976token 
        private static function tokenGenerate($componentToken){
            //formula matematica para gerar o token
            return $componentToken."token";
        }

        // usado para controlar a sessao e monitorar os acessos, 
        // todo json, passará por este filtro
        // se existir o token na sessao, retorna true, senao false
        // valida se existe json na request
        public static function monitorAcess($json){
            $token = JsonController::extractToken($json);
            return SessionController::validateSession($token);
        }
    }

?>