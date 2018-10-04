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
    }
    
?>