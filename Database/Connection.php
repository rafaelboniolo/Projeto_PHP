<?php

    // classe responsavel pelas operações no banco de forma dinâmica
    class Connection{

        include('Mysql.php');
        include("Util.php")

        $mysql = new Mysql();
        $util = new Util();

        private $where;
        private $orderBy;
        private $groupBy;
        
        public function toSelect($id, $table){
            
            $table = $util->classToTable($table);
            $idTable = $util->classToIdTable($table);
            
            
            $mysql->open();
            $data =  $mysql->query(
                " select * from $table where $idTable = $id $where $groupBy $orderBy "
            );
            $mysql->close();

            return $data;
        }

        public function toInsert($table, $fields, $values){
            
            $table = $util->classToTable($table);
            
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

        public function toDelete($table, $id){
            
            $table = $util->classToTable($table);
            $idTable = $util->classToIdTable($table);
            
            
            $mysql->open();
            $mysql->query(
                " delete from $table where $tableId = $id"
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