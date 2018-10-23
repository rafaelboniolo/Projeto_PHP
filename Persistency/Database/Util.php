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

        public function invokeMethod($class){
            $methods = Array();
            foreach (get_class_methods($class) as $key => $value) {
                if (strpos($value, 'set') !== false) 
                    array_push($methods, $value);
            }
            return $methods;
        }

        public static function teste(){
            echo "sss";
        }
    }

?>