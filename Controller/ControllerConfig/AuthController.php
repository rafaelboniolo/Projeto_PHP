<?php

    require_once (realpath(dirname(__FILE__) ). "\\Model\\vo\\Pessoa.php");
    
    class AuthController{

        private $token;

        private static function authenticate($pessoa){

        }

        private function tokenGenerate(){
            // gerar token com base na senha do usuario
            // o token vai na sessao e nos jsons vindos do cliente para o servidor
            $this->token = $token;
        }

        public static function startSession(){
            // levanta a sessao com o token do usuario
        }

    }

?>