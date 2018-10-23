<?php

    // classe responsavel pelas operações no banco de forma dinâmica
    
    require_once(realpath(dirname(__FILE__) )."/Util.php");
    require_once(realpath(dirname(__FILE__) )."/Mysql.php");

    $mysql = new Mysql;
    $util = new Util;

    class Connection {
           
        private $where;
        private $orderBy;
        private $groupBy;
    
        public function toSelect($id, $class){
            
            $table = $util->classToTable($class);
            $idTable = $util->classToIdTable($class);
            
            $mysql->open();
            $data =  $mysql->query(
                " select * from $table where $idTable = $id $where $groupBy $orderBy "
            );
            $mysql->close();

            return $data;
        
        }
        
        public function toSelectAll($class){
            
            $table = $util->classToTable($class);
                       
            $mysql->open();
            $data =  $mysql->query(
                " select * from $table where 1=1 $where $groupBy $orderBy "
            );
            $mysql->close();

            return $data;
        }
        

        public function toInsert($class, $fields, $values){
            
            $table = $util->classToTable($class);
            
            $mysql->open();
            $mysql->query(
                " insert into $table ($fields) values ($values) "
            );
            $mysql->close();
        }

        public function toUpdate(){
            $mysql->open();
            $mysql->query(
                ""
            );
            $mysql->close();
        }

        public function toDelete($class, $id){
            
            $table = $util->classToTable($class);
            $idTable = $util->classToIdTable($class);
            
            
            $mysql->open();
            $mysql->query(
                " delete * from $table where $classId = $id"
            );
            $mysql->close();
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

        
    }

?>