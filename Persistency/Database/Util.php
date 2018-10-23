<?php
    //apenas pra formatar os dados. Class -> table, Class ->id da table
    class Util{

        public function classToTable($class){
            $class = get_class($class);
            return 'tb_'.strtolower($class);
        }
        
        public function classToIdTable($class){
            $class = get_class($class);
            return 'id_'.strtolower($class);
        }

        public function populaObjeto($class, $data){
            print_r(get_class_methods($class));
        }


        private function extractVars($class){
            $fields = Array();
            foreach (get_class_methods($class) as $key => $value) {
                if (strpos($value, 'get') !== false) 
                    array_push($array, strtolower(substr($value,3)));
            } 
            return $fields;
        }
    }
    
?>