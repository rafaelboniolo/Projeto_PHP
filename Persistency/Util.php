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

        public static function classToTable($class){
            $class = get_class($class);
            return 'tb_'.strtolower($class);
        }
        
        public static function classToIdTable($class){
            $class = get_class($class);
            return 'id_'.strtolower($class);
        }

        public static function populaObjeto($class, $data){
            print_r(get_class_methods($class));
        }


        public static function extractFields($class){
            $fields = Array();
            foreach (get_class_methods($class) as $key => $value) {
                if (strpos($value, 'get') !== false && strpos(strtolower($value), 'id') === false) 
                    array_push($fields, strtolower(substr($value,3)));
            } 
            return Util::mountString($class, $fields, 'field');
        }

        private static function selectMethodsForClass($class, $type){
            $reflectionClass = new ReflectionClass(get_class($class));

            $methods = Array();

            foreach ($reflectionClass->getMethods() as $key => $value) {
                if (strpos($value, $type) !== false) 
                    $methods[$key] = $value;
            } 
            return $methods;
        }

        public static function popula($class, $data){
            
            $methods = Util::selectMethodsForClass($class, 'set');

            $i = 0;
            foreach ($methods as $method) {
               $method->invoke($class, $data[$i]);
                $i++;
            }

        }

        public static function collectValues($class){

            $methods = Util::selectMethodsForClass($class, 'get');

            $values = Array();

            foreach ($methods as $method) {
                if ( strpos(strtolower($method), 'id') !== false)
                    continue; 
                $result = $method->invoke($class);

                array_push($values, $result);

            }
            return Util::mountString($class, $values, 'value');
        }

        

        public static function mountString($class ,$array, $type){

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

        public static function extractId($class){

            $reflectionClass = new ReflectionClass(get_class($class));
            
            $id = '';

            foreach ($reflectionClass->getMethods() as $key => $value) {
                if (strpos($value, 'get') !== false && strpos(strtolower($value), "id") !== false) 
                    $method = $value;
            } 

            $id = $method->invoke($class);

            return $id;
        }

        
    }
?>