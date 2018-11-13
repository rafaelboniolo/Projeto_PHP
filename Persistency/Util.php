<?php

    class Util{

        public static function configMYSQL(){
            $pointer = fopen(realpath(dirname(__FILE__) )."\\Database\\_config.txt",'r'); // Obtém o ponteiro do arquivo _config.txt com permissão de leitura "r";
            $configMysql = explode("\n",fread($pointer, 200));  // Faz a leitura do ponteiro obtido e realiza a conversão para array utilizando o limitador "\n";
            $mysqlData = array();

            foreach($configMysql as $value){
                if(strchr($value,"DATABASE")){      // if utilizada para selecionar somente informações da configuração do banco, e evitar que "\n" gere alguma excessão no código;
                    $data = explode("=",$value);    // Utilizado para obter o nome e o valor de cada configuração do banco;
                    $mysqlData[str_replace("DATABASE.","",$data[0])] = trim($data[1]); // Utilizado somente para retirar o padrão DATABASE. de cada configuração
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
        public static function classToIdTable($class, $isUpper = false){
            
            if(!isset($class))
                throw new Exception("Classe não informada Util::classToIdTable", 1);
                
            $class = get_class($class);

            if($isUpper)
                return 'Id_'.strtolower($class);
            return 'id_'.strtolower($class);

        }

        // extrai os atributos para persistencia da classe
        // atraves da reflexão, encontrar os metodos de get e extrai o nome dos atributos de lá
        private static function collectFields($class){

            $nameId = Util::classToIdTable($class);

            if(!isset($class))
                throw new Exception("Classe não informada Util::collectFields", 1);
                

            $fields = Array();
            foreach (get_class_methods($class) as $key => $value) {
                if (strpos($value, 'get') !== false && strpos(strtolower($value), $nameId) === false) 
                    array_push($fields, strtolower(substr($value,3)));
            } 

            if(!isset($fields))
                throw new Exception("Classe não possui metodos de get ou atributos Util::collectFields", 1);
                

            return $fields;
        }

        // atraves da reflexão, invoca os metodos da $class para pegar os valores do get
        // utilizado para pegar os valores do objeto e persistir
        private static function collectValues($class){

            if(!isset($class))
                throw new Exception("Classe não informada Util::collectFields", 1);

            $methods = Util::selectMethodsForClass($class, 'get');

            $values = Array();

            $nameId = Util::classToIdTable($class);

            foreach ($methods as $method) {
                if ( strpos(strtolower($method), $nameId) !== false)
                    continue; 
                $result = $method->invoke($class);

                array_push($values, $result);

            }

            
            if(!isset($class))
                throw new Exception("Classe não existem methodos de get, ou os atributos estão vazios Util::collectValues", 1);

            return $values;
        }

        
        private static function collectFieldsAndCollectValues($class){
            if(!isset($class))
                throw new Exception("Classe não informada Util::collectFields", 1);

            $methods = Util::selectMethodsForClass($class, 'get');

            $values = Array();
            $fieldsAndValues = Array();

            $nameId = Util::classToIdTable($class);

            foreach ($methods as $method) {
                if ( strpos(strtolower($method), $nameId) !== false)
                    continue; 
                
                $result = $method->invoke($class);

                if($result!=''){
                    $fieldsAndValues[strtolower(substr($method->name,3))] = $result;
                } 

            }

            return $fieldsAndValues;
        }


        // adapter
        public static function collectFieldsMountStringInsert($class){
            $fields = Util::collectFields($class);
            return Util::mountStringSQL($fields, 'insertField');
        }

        //adapter
        public static function collectValuesMountStringInsert($class){
            $values = Util::collectValues($class);
            return Util::mountStringSQL($values, 'insertValue');
        }
        
        public static function collectFieldsAndCollectValuesMountStringFind($class){
            $fieldsAndValues = Util::collectFieldsAndCollectValues($class);
            return Util::mountStringSQL($fieldsAndValues,"find");
        }
        public static function collectFieldsAndCollectValuesMountStringUpdate($class){
            $fieldsAndValues = Util::collectFieldsAndCollectValues($class);
            return Util::mountStringSQL($fieldsAndValues,"update");
        }
        
        

        private static function mountStringSQL($array, $type){
           
            if(!isset($array))
                throw new Exception("O array não foi informado Util::mountStringSQL", 1);

            if(!isset($type))
                throw new Exception("O type não foi informado Util::mountStringSQL", 1);

            

            $string="";

            if($type == "insertValue"){
                for ($i=0; $i < count($array); $i++) { 
                    $str = $array[$i];
                    if($i != count($array)-1)
                        $str = "\"$str\",";
                    else
                        $str = "\"$str\"";
                    
                    $string .= $str;
                
                }
            }else if($type == "insertField"){
                for ($i=0; $i < count($array); $i++) { 
                    $str = $array[$i];
                    if($i == count($array)-1){
                        $string .= $str;
                    }else{
                        $str = $str.",";
                        $string .= $str;
                    }
                }

            }else if($type == "find"){
              
                foreach ($array as $field => $value) {
                    $string.= " and $field = \"$value\" ";
                }

            }else if($type == "update"){
                foreach ($array as $field => $value){ 
                    $string .= $field." = \"$value\",  ";
                }

                $string = substr($string, 0, strlen($string)-3);

                echo $string;
            }
            

            return $string;

        }

       

        // pega todos os metodos da $class via reflexão, o type pode ser metodos de get, set, ou ambos
        private static function selectMethodsForClass($class, $type){
            
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
            
            
            foreach ($methods as $method) {
               $method->invoke($class, $data[strtolower(substr($method->name,3))]);
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
            $nameId = Util::classToIdTable($class);


            foreach ($reflectionClass->getMethods() as $key => $value) {
                if (strpos($value, 'get') !== false && strpos(strtolower($value), $nameId) !== false) 
                    $method = $value;
            } 
            if(!isset($method))
                throw new Exception("Nenhum metodo encontrado Util::extractId", 1);
                
            $id = $method->invoke($class);

            if(!isset($id))
                throw new Exception("Nenhum id encontrado Util::extractId", 1);
            

            return $id;
        }

        


        public function setIdAfterInsert($class, $data){
            
            
            if(!isset($class))
                throw new Exception("Classe não informada Util::setIdAfterInsert", 1);
                
            if(!isset($data))
            throw new Exception("Data não informado Util::setIdAfterInsert", 1);

            $nameId = Util::classToIdTable($class, true);

            $nameId =  'set'.$nameId;

            $method = Util::selectMethodsForClass($class, $nameId);
    
            $method[1]->invoke($class, $data['max_id']);
                
           
        }       
    }
?>