<?php

    //require_once(realpath(dirname(__FILE__) )."\\Database\\_config.txt");

    class Util{


        public static function configMYSQL(){
            $pointer = fopen(realpath(dirname(__FILE__) )."\\Database\\_config.txt",'r'); // Obtém o ponteiro do arquivo _config.txt com permissão de leitura "r";
            $configMysql = explode("\n",fread($pointer, 200));  // Faz a leitura do ponteiro obtido e realiza a conversão para array utilizando o limitador "\n";
            $mysqlData = array();

            foreach($configMysql as $value){
                if(strchr($value,"DATABASE")){      // if utilizada para selecionar somente informações da configuração do banco, e evitar que "\n" gere alguma excessão no código;
                    $data = explode("=",$value);    // Utilizado para obter o nome e o valor de cada configuração do banco;
                    $mysqlData[str_replace("DATABASE.","",$data[0])] = $data[1]; // Utilizado somente para retirar o padrão DATABASE. de cada configuração
                }
            }

            return($mysqlData);     // retorno do array associativo com as configurações do BD
        }


        // converte o nome de uma classe para uma tabela
        public static function classToTable($class){

            if(!isset($class))
                throw new Exception("Classe não informada Util::classToTable", 1);
                
            $class = get_class($class);
            return 'tb_'.strtolower($class);
        }

        // converte o nome de uma classe para o id da tabela
        public static function classToIdTable($class){
            
            if(!isset($class))
                throw new Exception("Classe não informada Util::classToIdTable", 1);
                
            $class = get_class($class);
            return 'id_'.strtolower($class);
        }

        // extrai os atributos para persistencia da classe
        // atraves da reflexão, encontrar os metodos de get e extrai o nome dos atributos de lá
        public static function extractFields($class){

            if(!isset($class))
                throw new Exception("Classe não informada Util::extractFields", 1);
                

            $fields = Array();
            foreach (get_class_methods($class) as $key => $value) {
                if (strpos($value, 'get') !== false && strpos(strtolower($value), 'id') === false) 
                    array_push($fields, strtolower(substr($value,3)));
            } 

            if(!isset($fields))
                throw new Exception("Classe não possui metodos de get ou atributos Util::extractFields", 1);
                

            return $fields;
        }

        // atraves da reflexão, invoca os metodos da $class para pegar os valores do get
        // utilizado para pegar os valores do objeto e persistir
        public static function collectValues($class){

            if(!isset($class))
                throw new Exception("Classe não informada Util::extractFields", 1);

            $methods = Util::selectMethodsForClass($class, 'get');

            $values = Array();

            foreach ($methods as $method) {
                if ( strpos(strtolower($method), 'id') !== false)
                    continue; 
                $result = $method->invoke($class);

                array_push($values, $result);

            }

            
            if(!isset($class))
                throw new Exception("Classe não existem methodos de get, ou os atributos estão vazios Util::collectValues", 1);

            return $values;
        }

        // adapter
        public static function extractFieldsMountStringInsert($class){
            $fields = Util::extractFields($class);
            return Util::mountStringInsert($class, $fields, 'field');
        }

        //adapter
        public static function collectValuesMountStringInsert($class){
            $values = Util::collectValues($class);
            return Util::mountStringInsert($class, $values, 'value');
        }        

        // com base no tipo(field, value), monta o array para insert
        public static function mountStringInsert($class ,$array, $type){

            
            if(!isset($class))
                throw new Exception("Classe não informada Util::mountStringInsert", 1);

                
            if(!isset($array))
                throw new Exception("O array não foi informado Util::mountStringInsert", 1);

            if(!isset($type))
                throw new Exception("O type não foi informado Util::mountStringInsert", 1);

            

            $string="";

            if($type == "value"){
                for ($i=0; $i < count($array); $i++) { 
                    $str = $array[$i];
                    if($i != count($array)-1)
                        $str = "\"".$str."\",";
                    else
                        $str = "\"".$str."\"";
                    
                    $string .= $str;
                
                }
            }else if($type == "field"){
                for ($i=0; $i < count($array); $i++) { 
                    $str = $array[$i];
                    if($i == count($array)-1){
                        $string .= $str;
                    }else{
                        $str = $str.",";
                        $string .= $str;
                    }
                }

            }

            return $string;

        }

        // pega todos os metodos da $class via reflexão, o type pode ser metodos de get, set, ou ambos
        public static function selectMethodsForClass($class, $type){
            
            if(!isset($class))
                throw new Exception("Classe não informada Util::selectMethodsForClass", 1);

            if(!isset($type))
                throw new Exception("type não informado Util::selectMethodsForClass", 1);

            $reflectionClass = new ReflectionClass(get_class($class));

            if(!isset($reflectionClass))
                throw new Exception("Classe não existe Util::selectMethodsForClass", 1);


            $methods = Array();

            foreach ($reflectionClass->getMethods() as $key => $value) {
                if (strpos($value, $type) !== false) 
                    $methods[$key] = $value;
            } 
            return $methods;
        }

        // popula o objeto que extende connection
        public static function popula($class, $data){

            if(!isset($class))
                throw new Exception("Classe não informada Util::popula", 1);
                
            if(!isset($data))
            throw new Exception("Data não informado Util::popula", 1);


            $methods = Util::selectMethodsForClass($class, 'set');

            $i = 0;
            foreach ($methods as $method) {
               $method->invoke($class, $data[$i]);
                $i++;
            }

        }

        public static function populaAll($class, $data){
            if(!isset($class))
                throw new Exception("Classe não informada Util::populaAll", 1);
          
            if(!isset($data))
                throw new Exception("Data não informado Util::populaAll", 1);
              
            $all = Array();

            for ($i=0; $i < $data->num_rows ; $i++) { 
                $obj = new $class();
                
                Util::popula($obj, $data->fetch_array());
                
                array_push($all, $obj);   
            }

            return $all;
            
        }

        //extrai o valor id da classe
        public static function extractId($class){

            $reflectionClass = new ReflectionClass(get_class($class));
            
            if(!isset($reflectionClass))
                throw new Exception("Classe não existe Util::extractId", 1);


            $id = '';

            foreach ($reflectionClass->getMethods() as $key => $value) {
                if (strpos($value, 'get') !== false && strpos(strtolower($value), "id") !== false) 
                    $method = $value;
            } 
            if(!isset($method))
                throw new Exception("Nenhum metodo encontrado Util::extractId", 1);
                
            $id = $method->invoke($class);

            if(!isset($id))
                throw new Exception("Nenhum id encontrado Util::extractId", 1);
            

            return $id;
        }

        // formata a string de update
        public static function mountStringUpdate($class){


            if(!isset($class))
                throw new Exception("Classe não informada Util::mountStringUpdate ", 1);
            

            $values = Util::collectValues($class);
            $fields = Util::extractFields($class);
            

            if(count($values) != count($fields))
                throw new Exception("Quantidade diferente de fields e values mountStringUpdate", 1);
            
            $string = "";
            
            for ($i=0; $i < count($values) ; $i++) { 
               
                if($i+1 == count($values))
                    $string .= $fields[$i]." =  \"".$values[$i]."\"";
                else
                $string .= $fields[$i]." = \"".$values[$i]."\",  ";

            }

            return $string;

        }

        
    }
?>