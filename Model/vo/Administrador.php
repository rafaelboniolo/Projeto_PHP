<?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    if(!PROTECTED_PROJECT::ANALYZE()) return;


    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Persistency\\Persistency.php");

    class Administrador extends Persistency{
        

        private $id_administrador;
        private $id_pessoa;
        
        
        public function getId_administrador(){
            return $this->id_administrador;
        }

        public function setId_administrador($id_administrador){
            $this->id_administrador = $id_administrador;
            return $this;
        }

        public function getId_pessoa(){
            return $this->id_pessoa;
        }

        public function setId_pessoa($id_pessoa){
            $this->id_pessoa = $id_pessoa;
            return $this;
        }
        public function myId(){
            return $this->getId_administrador();
        }
        
        public function findall(){
            return parent::findall_($this);
        }

        public function findById(){
            parent::findById_($this);
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