<?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    if(!PROTECTED_PROJECT::ANALYZE()) return;

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Persistency\\Persistency.php");

    class Gestor extends Persistency{
        
        private $id_gestor;
        private $id_pessoa;
        private $meta;
        private $giromaximo;

        public function getId_gestor(){
            return $this->id_gestor;
        }

        public function setId_gestor($id_gestor){
            $this->id_gestor = $id_gestor;
            return $this;
        }

        public function getId_pessoa(){
            return $this->id_pessoa;
        }

        
        public function setId_pessoa($id_pessoa){
            $this->id_pessoa = $id_pessoa;
            return $this;
        }

        public function getMeta(){
            return $this->meta;
        }

        public function setMeta($meta){
            $this->meta = $meta;
            return $this;
        }
        
        public function getGiromaximo(){
            return $this->giromaximo;
        }

        public function setGiromaximo($giromaximo){
            $this->giromaximo = $giromaximo;
            return $this;
        }
        

        public function myId(){
            return $this->getId_gestor();
        }
        

        public function findall(){
            return parent::findall_($this);
        }

        public function findById(){
            parent::findById_($this);
            return $this;
        }

        public function findByAtributes(){
            return parent::findByAtributes_($this);
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