<?php

   require_once (realpath('../../Persistency/Connection.php' ));

    class Investidor extends Connection{
        
        private $id_pessoa;
        
        public function getId_pessoa(){
            return $this->id_pessoa;
        }

        public function setId_pessoa($id_pessoa){
            $this->id_pessoa = $id_pessoa;
            return $this;
        }

        public function findall(){
            return parent::findall_($this);
        }

        public function find(){
            parent::find_($this);
            return $this;
        }

        public function insert(){
            parent::insert_($this);
            return $this;
        }

        public function update(){
            parent::update_($this);
            return $this;
        }

        public function delete(){
            parent::delete_($this);
            return $this;
        }

    }
    


?>