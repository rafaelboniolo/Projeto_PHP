<?php

    // classe responsavel pelas operações no banco de forma dinâmica
    
    include(realpath(dirname(__FILE__) )."\\Util.php");
    include(realpath(dirname(__FILE__) )."\\Mysql.php");

    class Connection extends Mysql{
    
        
        private $where;
        private $orderBy;
        private $groupBy;
        private $Util;

        public function __construct(){
            $this->Util = $this->getUtil();
        }
    
        public function toSelect($id, $class){
            
            $table = $Util::classToTable($class);
            $idTable = $Util::classToIdTable($class);
            
            parent::open();
            $data =  parent::query(
                " select * from $table where $idTable = $id $where $groupBy $orderBy "
            );
            parent::close();

            return $data;
        
        }
        
        public function toSelectAll($class){
            
            $table = $Util::classToTable($class);
                       
            parent::open();
            $data =  parent::query(
                " select * from $table where 1=1 $where $groupBy $orderBy "
            );
            parent::close();

            return $data;
        }
        

        public function toInsert($class, $fields, $values){
            
            $table = $Util::classToTable($class);
            
            parent::open();
            parent::query(
                " insert into $table ($fields) values ($values) "
            );
            parent::close();
        }

        public function toUpdate(){
            parent::open();
            parent::query(
                ""
            );
            parent::close();
        }

        public function toDelete($class, $id){
            
            $table = $Util::classToTable($class);
            $idTable = $Util::classToIdTable($class);
            
            
            parent::open();
            parent::query(
                " delete * from $table where $classId = $id"
            );
            parent::close();
        }

        public function where($where){
            $this->where = $where;
        }

        public function orderBy($orderBy){
            $this->orderBy = $orderBy;
        }

        public function groupBy($groupBy){
            $this->groupBy = $groupBy;
        }


       public function getUtil(){
            return new Util();
        }
        
    }

?>