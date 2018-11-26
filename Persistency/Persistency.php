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

        public function __construct(){
            $this->DatabaseUtil = $this->returnDatabaseUtil();
        }
    
        public function findById_($class){
            
            $id =$this->DatabaseUtil::extractId($class);
            $table = $this->DatabaseUtil::classToTable($class);
            $idTable = $this->DatabaseUtil::classToIdTable($class);
        
            parent::open();
            
            $data =  parent::query(
                " select * from $table where $idTable = $id  $this->where $this->groupBy $this->orderBy ;"
            );
            parent::close();

            $this->DatabaseUtil::popula($class ,$data->fetch_array(),true);
        
        }

        public function findByAtributes_($class){
            
            $table = $this->DatabaseUtil::classToTable($class);
            $idTable = $this->DatabaseUtil::classToIdTable($class);
            $stringFind = $this->DatabaseUtil::collectFieldsAndCollectValuesMountStringFind($class);

            parent::open();

            
            $data =  parent::query(
                " select * from $table where 1=1 $stringFind  $this->where $this->groupBy $this->orderBy ;"
            );
            parent::close();

            if($data->num_rows == 1){
                $this->DatabaseUtil::popula($class ,$data->fetch_array(),true);
                return Array('rows'=>$data->num_rows, 'data'=>$class);
            }
            if($data->num_rows > 1)
               return Array('rows'=>$data->num_rows, 'data'=>$this->DatabaseUtil::populaAll($class ,$data, true));
        
            return Array('rows'=>$data->num_rows, 'data'=>'empty');

        }


        
        //["data"] retorna a lista de objetos buscados
        //["rows"] retorna o numero de linhas afetadas
        public function findall_($class){
            
            $table = $this->DatabaseUtil::classToTable($class);
            
            parent::open();
            
            $data =  parent::query(
                " select * from $table where 1=1 $this->where $this->groupBy $this->orderBy ;"
            );
            parent::close();

            return Array('rows'=>$data->num_rows, 'data'=>$this->DatabaseUtil::populaAll($class ,$data));
        
        }
        

        public function insert_($class){
            
            $table = $this->DatabaseUtil::classToTable($class);
            $fields = $this->DatabaseUtil::collectFieldsMountStringInsert($class);
            $values = $this->DatabaseUtil::collectValuesMountStringInsert($class);
            $idTable = $this->DatabaseUtil::classToIdTable($class);
            
            parent::open();
            parent::query(
                " insert into $table ($fields) values ($values); "
            );

            $this->DatabaseUtil::setIdAfterInsert($class ,parent::insert_id());

            parent::close();

        }

        public function update_($class){

            $id =$this->DatabaseUtil::extractId($class);
            $table = $this->DatabaseUtil::classToTable($class);
            $idTable = $this->DatabaseUtil::classToIdTable($class);
            
            $set = DatabaseUtil::collectFieldsAndCollectValuesMountStringUpdate($class);


            parent::open();
            parent::query(
                " update $table set $set where $idTable = $id $this->where ; "
            );
            parent::close();

        }

        public function delete_($class){
            
            $id =$this->DatabaseUtil::extractId($class);
            $table = $this->DatabaseUtil::classToTable($class);
            $idTable = $this->DatabaseUtil::classToIdTable($class);
            
            parent::open();
            parent::query(
                " delete from $table where $idTable = $id ;"
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


       public function returnDatabaseUtil(){
            return new DatabaseUtil();
        }
        
    }

?>