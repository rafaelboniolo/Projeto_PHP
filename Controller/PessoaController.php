<?php

    require_once (realpath("Model\\vo\\Pessoa.php"));

    class PessoaController{

        // busca login e senha no banco de dados e retorna false ou o user
        public static function authenticate($login, $password){
            $user = new Pessoa();

            $rows = $user
                    ->setLogin($login)
                    ->setSenha($password)
                    ->findByAtributes()['rows'];
                    
            if($rows != 1) return false;

            return $user;
        }

    }

?>