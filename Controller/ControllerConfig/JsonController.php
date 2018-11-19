<?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    //if(!PROTECTED_PROJECT::ANALYZE()) return;

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Persistency\\DatabaseUtil.php");  
         
    class JsonController{

        public static function json_class($json){
            // extrai a classe do json
            // popula a classe com o json
            // retorna a classe

             // recebe Json e converte para array

            $aux = json_decode($json,true)["dados"]["1"]; // extraindo dados Json, sempre pegando a primeira pessoa

            $class= json_decode($json,true)["config"]["class"]; // extraindo o nome da classe do array

            $reflectionClass = new ReflectionClass($class); // encontrar a classe via Reflection

            DatabaseUtil::popula($aux,$reflectionClass); // set valores do array na classe 

            return $reflectionClass;

        }
        
        public static function class_json($class){
            // extrai os valores da classe e atribui ao json


        }

        private static function codeGenerate($class){
            // gera um codigo de rastreio para o json, baseado na classe enviada
            // da pra gerar um calculo com base no ASCII do nome da classe
        }

        //abre todo json vindo do front-end e extrai o token
        //a forma de extracao vai variar de acordo com a estrutura do json
        //baseado no json -> CLASS_JSON.json
        public static function extractToken($json){
            return json_decode($json,true)['config']['token'];
        }

        //verifica se tem um json na requisicao
        public static function hasJson($json){
            
            if(!isset($json)||$json==""){
                print_r(Array('error'=>'no json provider'));
                http_response_code(400);
                return false;
            }
            return true;

        }
        
        
        
    }

    // TESTE
    
     // $arr = array("classe" => "Pessoa", "nome" => "Rafael", "cpf"=>"645646687");
         //echo json_encode($arr). "<br>";
    //  JsonController::json_class(json_encode($arr));


    //$cam = "..\\".realpath(dirname(__FILE__));
    //print_r($cam);
    //echo "\n\n\n\n aiim";

?>