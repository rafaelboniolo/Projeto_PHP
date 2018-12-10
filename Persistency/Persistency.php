<?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    if(!PROTECTED_PROJECT::ANALYZE()) return;

    // classe responsavel pelas operações no banco de forma dinâmica
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Persistency\\DatabaseUtil.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Persistency\\ConnectionMysql.php");

    class Persistency extends ConnectionMysql{
    
        
        private $where=' ';
        private $orderBy=' ';
        private $groupBy=' ';
        private $DatabaseUtil;

        
        public function findById_($class){
            
            $id = DatabaseUtil::extractId($class);
            $table = DatabaseUtil::classToTable($class);
            $idTable = DatabaseUtil::classToIdTable($class);
        
            
            $data = ConnectionMysql::query(
                " select * from $table where $idTable = $id  $this->where $this->groupBy $this->orderBy ;"
            );

            DatabaseUtil::popula($class ,$data['data']->fetch_array(),true);
        
        }

        public function findByAtributes_($class){
            
            $table = DatabaseUtil::classToTable($class);
            $idTable = DatabaseUtil::classToIdTable($class);
            $stringFind = DatabaseUtil::collectFieldsAndCollectValuesMountStringFind($class, true);


            $data = ConnectionMysql::query(
                " select * from $table where 1=1 $stringFind  $this->where $this->groupBy $this->orderBy ;"
            );

            
            if($data['data']->num_rows == 1){
                DatabaseUtil::popula($class ,$data['data']->fetch_array(),true);
                return Array('rows'=>$data['data']->num_rows, 'data'=>Array($class));
            }
            if($data['data']->num_rows > 1)
               return Array('rows'=>$data['data']->num_rows, 'data'=>DatabaseUtil::populaAll($class ,$data['data'], true));
        
            return Array('rows'=>$data['data']->num_rows, 'data'=>'empty');

        }


        
        //["data"] retorna a lista de objetos buscados
        //["rows"] retorna o numero de linhas afetadas
        public function findall_($class){
            
            $table = DatabaseUtil::classToTable($class);
            
            $data = ConnectionMysql::query(
                " select * from $table where 1=1  $this->where $this->groupBy $this->orderBy ;"
            );

            // print_r($data['data']->num_rows);
            return Array('rows'=>($data['data']->num_rows), 'data'=>DatabaseUtil::populaAll($class ,$data['data']));
        
        }
        

        public function insert_($class){
            
            $table = DatabaseUtil::classToTable($class);
            $fields = DatabaseUtil::collectFieldsMountStringInsert($class);
            $values = DatabaseUtil::collectValuesMountStringInsert($class);
            $idTable = DatabaseUtil::classToIdTable($class);
            
          
            $data = ConnectionMysql::query(
                " insert into $table ($fields) values ($values); "
            );

            echo " insert into $table ($fields) values ($values); ";

            DatabaseUtil::setIdAfterInsert($class ,$data['id']);
         

        }

        public function update_($class){

            $id =DatabaseUtil::extractId($class);
            $table = DatabaseUtil::classToTable($class);
            $idTable = DatabaseUtil::classToIdTable($class);
            
            $set = DatabaseUtil::collectFieldsAndCollectValuesMountStringUpdate($class);

            $data = ConnectionMysql::query(
                " update $table set $set where $idTable = $id $this->where ; "
            );

        }

        public function delete_($class){
            
            $id = DatabaseUtil::extractId($class);
            $table = DatabaseUtil::classToTable($class);
            $idTable = DatabaseUtil::classToIdTable($class);
            
            $data = ConnectionMysql::query(
                " delete from $table where $idTable = $id ;"
            );

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