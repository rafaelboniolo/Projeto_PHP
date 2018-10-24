<?php
    //apenas pra formatar os dados. Class -> table, Class ->id da table
    class Util{

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


        public static function extractVars($class){
            $fields = Array();
            foreach (get_class_methods($class) as $key => $value) {
                if (strpos($value, 'get') !== false) 
                    array_push($array, strtolower(substr($value,3)));
            } 
            return $fields;
        }

        private static function selectMethodsForClass($class){
            $reflectionClass = new ReflectionClass(get_class($class));

            $methods = Array();

            foreach ($reflectionClass->getMethods() as $key => $value) {
                if (strpos($value, 'set') !== false) 
                    $methods[$key] = $value;
            } 
        
            return $methods;
        }

        public static function popula($class, $data){
            
            $methods = Util::selectMethodsForClass($class);
         
            for ($i=0; $i < strlen($data); $i++) { 
                $methods[$i]->invoke($class, $data[$i]);
            }
        }

        public function converte($reg){

            return $data;
        }

        
    }

?>