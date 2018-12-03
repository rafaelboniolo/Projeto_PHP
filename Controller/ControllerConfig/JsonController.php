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
            
            $qtd = json_decode($json, true)['config']['dados'];
            $dados = Array();

           for ( $i=0; $i < $qtd; $i++) { 
                $class = JsonController::getClassFromJson($json);
                $data = json_decode($json,true)['dados'][$i];
                DatabaseUtil::popula($class, $data, $validateId); // set valores do array na classe 
                array_push($dados, $class);
           }
           return $dados;
        }

        public static function getClassFromJson($json){
            
            $className = json_decode($json, true)['config']['class']; 
            
            try{
                $reflectionClass = new ReflectionClass($className); // encontrar a classe via Reflection
            }catch(ReflectionException $exception){
                print_r(json_encode(Array("error"=>"Classe nao encontrada:".$className)));
                throw new Exception("Classe nao encontrada! JsonController::jsonClass".$className, 1);
                http_response_code(404);
                return ;    
            }
            
            return $reflectionClass->newInstance(new stdClass());
        }
    
        
        public static function class_json($classes){
            $fieldsAndValues=Array();
            foreach ($classes as $class) {
                $fav = DatabaseUtil::collectFieldsAndCollectValues($class, true);   
                array_push($fieldsAndValues, $fav);
            }
               
            return $fieldsAndValues;
        }
        
        
        

       
        //abre todo json vindo do front-end e extrai o token
        //a forma de extracao vai variar de acordo com a estrutura do json
        //baseado no json -> CLASS_JSON.json
        public static function extractToken($json){
            return base64_decode(json_decode($json,true)['config']['token']);
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

        public static function getConfig($class, $dados=1){
            return Array("token"=>"","class"=>get_class($class),"dados"=>$dados);
        }
        
        
        
    }

   
?>