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
    
    
      
         
    class JsonController{

        public static function json_class($json, $validateId=false){
            // extrai a classe do json
            // popula a classe com o json
            // retorna a classe

            
           $className = json_decode($json, true)['config']['class']; // extraindo o nome da classe do array
           
            $data = json_decode($json,true)['dados']['1'];

            try{
                $reflectionClass = new ReflectionClass($className); // encontrar a classe via Reflection
            }catch(ReflectionException $exception){
                print_r(json_encode(Array("error"=>"Classe nao encontrada:".$className)));
                throw new Exception("Classe nao encontrada! JsonController::jsonClass".$className, 1);
                http_response_code(404);
                return ;    
            }
            
            $class = $reflectionClass->newInstance(new stdClass());

            DatabaseUtil::popula($class, $data, $validateId); // set valores do array na classe 

            return $class;

        }
        
    
        
        public static function class_json($class,$index=1){
            $fieldsAndValues = DatabaseUtil::collectFieldsAndCollectValues($class, true);
            return json_encode(JsonController::getConfig($class, Array(1=>$fieldsAndValues)));
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
                print_r(json_encode(Array('error'=>'no json provider')));
                http_response_code(400);
                return false;
            }
            return true;

        }

        public static function getConfig($class, $dados){
            return Array("token"=>"","class"=>get_class($class),"dados"=>$dados);
        }
        
        
        
    }

   
?>