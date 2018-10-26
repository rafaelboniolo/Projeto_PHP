<?php

    //require_once(realpath(dirname(__FILE__) )."\\Database\\_config.txt");

    class Util{


        public static function configMYSQL(){
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