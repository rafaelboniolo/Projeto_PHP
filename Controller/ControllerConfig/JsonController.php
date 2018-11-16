<?php

require_once(realpath('./../../Persistency\\DatabaseUtil.php'));

       
    class JsonController{

        public static function json_class($json){
            // extrai a classe do json
            // popula a classe com o json
            // retorna a classe

            $obj = json_decode($json,true); // recebe Json e converte para array

            $aux = array_shift($obj); // retira primeiro array

            print_r($aux);

            echo "$aux";
            $class = get_class($aux);

            $reflectionClass = new ReflectionClass($aux); // encontrar a classe

            print_r($reflectionClass);
            print_r($obj["classe"]);
            echo "<br/>";
            
            foreach($obj as $key => $value){ // percorrer array
               echo $value;
            }

           DatabaseUtil::popula($aux,$obj);

            return $class;

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

    // TESTE
    
    $arr = array("classe" => "Pessoa", "nome" => "Rafael", "cpf"=>"645646687");
    echo json_encode($arr). "<br>";
    JsonController::json_class(json_encode($arr));


    //$cam = "..\\".realpath(dirname(__FILE__));
    //print_r($cam);
    //echo "\n\n\n\n aiim";

?>