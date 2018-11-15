<?php

    class JsonController{

        public static function json_class($json){
            // extrai a classe do json
            // popula a classe com o json
            // retorna a classe
        }
        
        public static function class_json($class){
            // extrai os valores da classe e atribui ao json
        }

        private static function codeGenerate($class){
            // gera um codigo de rastreio para o json, baseado na classe enviada
            // da pra gerar um calculo com base no ASCII do nome da classe
        }

        public static function extractToken($json){
            return json_decode($json,true)['token'];
        }

        
        
        
    }


?>