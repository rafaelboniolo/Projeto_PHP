<?php

    // classe responsavel pelas operações no banco de forma dinâmica
    
    include(realpath(dirname(__FILE__) )."\\Util.php");
    include(realpath(dirname(__FILE__) )."\\Mysql.php");

    class Connection extends Mysql{
    
        
        private $where=' ';
        private $orderBy=' ';
        private $groupBy=' ';
        private $Util;

        public function __construct(){
            $this->Util = $this->returnUtil();
        }
    
        public function findById_($class){
            
            $id =$this->Util::extractId($class);
            $table = $this->Util::classToTable($class);
            $idTable = $this->Util::classToIdTable($class);
        
            parent::open();
            
            $data =  parent::query(
                " select * from $table where $idTable = $id  $this->where $this->groupBy $this->orderBy ;"
            );
            parent::close();

            $this->Util::popula($class ,$data->fetch_array());
        
        }

        public function findByAtributes_($class){
            
            $table = $this->Util::classToTable($class);
            $idTable = $this->Util::classToIdTable($class);
            $stringFind = $this->Util::collectFieldsAndCollectValuesMountStringFind($class);

            parent::open();

            $data =  parent::query(
                " select * from $table where 1=1 $stringFind  $this->where $this->groupBy $this->orderBy ;"
            );
            parent::close();

            if($data->num_rows == 1){
                $this->Util::popula($class ,$data->fetch_array());
                return Array('rows'=>$data->num_rows, 'data'=>$class);
            }
            if($data->num_rows > 1)
               return Array('rows'=>$data->num_rows, 'data'=>$this->Util::populaAll($class ,$data));
        
            return Array('rows'=>$data->num_rows, 'data'=>'empty');

        }


        
        //["data"] retorna a lista de objetos buscados
        //["rows"] retorna o numero de linhas afetadas
        public function findall_($class){
            
            $table = $this->Util::classToTable($class);
            
            parent::open();
            
            $data =  parent::query(
                " select * from $table where 1=1 $this->where $this->groupBy $this->orderBy ;"
            );
            parent::close();

            return Array('rows'=>$data->num_rows, 'data'=>$this->Util::populaAll($class ,$data));
        
        }
        

        public function insert_($class){
            
            $table = $this->Util::classToTable($class);
            $fields = $this->Util::collectFieldsMountStringInsert($class);
            $values = $this->Util::collectValuesMountStringInsert($class);
            $idTable = $this->Util::classToIdTable($class);
            
            parent::open();
            parent::query(
                " insert into $table ($fields) values ($values); "
            );

            $data = parent::query(
                " select max($idTable) as max_id from   $table; "
            );

            parent::close();

            $this->Util::setIdAfterInsert($class ,$data->fetch_array());
        }

        public function update_($class){

            $id =$this->Util::extractId($class);
            $table = $this->Util::classToTable($class);
            $idTable = $this->Util::classToIdTable($class);
            
            $set = Util::collectFieldsAndCollectValuesMountStringUpdate($class);


            parent::open();
            parent::query(
                " update $table set $set where $idTable = $id $this->where ; "
            );
            parent::close();

        }

        public function delete_($class){
            
            $id =$this->Util::extractId($class);
            $table = $this->Util::classToTable($class);
            $idTable = $this->Util::classToIdTable($class);
            
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


       public function returnUtil(){
            return new Util();
        }
        
    }

?>