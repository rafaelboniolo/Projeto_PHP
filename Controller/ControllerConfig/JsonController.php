<?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    //if(!PROTECTED_PROJECT::ANALYZE()) return;

    require_once ("C:\\xampp\\htdocs\\projeto_php\\Persistency\\DatabaseUtil.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Pessoa.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Administrador.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Gestor.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Investidor.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Acao.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\ConfigTaxa.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Transacao.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\HistoricoAcao.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\SolicitacaoSaque.php");
    
      
         
    class JsonController{

        public static function json_class($json, $validateId=false){
            
       // print_r($json);    

            $class = JsonController::instanceClass();

            $classes = Array();

            foreach (json_decode($json,true) as $data) {
                DatabaseUtil::popula($class, $data, $validateId); // set valores do array na classe 
                array_push($classes, $class);
            }
                

           return $classes;
        }




        public static function instanceClass(){
            $className = $_SERVER['HTTP_CLASS'];
            try{
                $reflectionClass = new ReflectionClass($className); // encontrar a classe via Reflection
            }catch(ReflectionException $exception){
                print_r(json_encode(Array("error"=>"Classe nao encontrada:".$className)));
                throw new Exception("Classe nao encontrada! JsonController::instance".$className, 1);
                http_response_code(404);
                return ;    
            }
            
            return $reflectionClass->newInstance();
        }
    
        
        public static function class_json($classes){
            $fieldsAndValues=Array();
            if(!is_array($classes))
                $classes = Array($classes);

            
            foreach ($classes as $class) {
                $fav = DatabaseUtil::collectFieldsAndCollectValues($class, true);   
                array_push($fieldsAndValues, $fav);
            }               
            return $fieldsAndValues;
        }
        
        
        

       
        //abre todo json vindo do front-end e extrai o token
        //a forma de extracao vai variar de acordo com a estrutura do json
        //baseado no json -> CLASS_JSON.json
        public static function extractToken(){
            return json_decode(base64_decode($_SERVER['HTTP_BEARER']), true);
        }


        // public static function getConfig(){
        //     return Array("token"=>"","class"=>get_class($class),"dados"=>$dados);
        // }
        
        
        
    }

   
?>