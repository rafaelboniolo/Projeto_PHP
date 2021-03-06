<?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    if(!PROTECTED_PROJECT::ANALYZE()) return;
    
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Persistency\\Persistency.php");

    class ConfigTaxa extends Persistency{
        
        private $id_configtaxa;
        private $id_administrador;
        private $taxasaque;
        private $taxafundo;
        private $data;


      
        public function getId_configtaxa(){
            return $this->id_configtaxa;
        }

        
        public function setId_configtaxa($id_configtaxa){
            $this->id_configtaxa = $id_configtaxa;
            return $this;
        }

         
        public function getId_administrador(){
            return $this->id_administrador;
        }

         
        public function setId_administrador($id_administrador){
            $this->id_administrador = $id_administrador;
            return $this;
        }

         
        public function getTaxasaque(){
            return $this->taxasaque;
        }

         
        public function setTaxasaque($taxasaque){
            $this->taxasaque = $taxasaque;
            return $this;
        }

        
        public function getTaxafundo(){
            return $this->taxafundo;
        }

        
        public function setTaxafundo($taxafundo){
            $this->taxafundo = $taxafundo;
            return $this;
        }

        
        public function getData(){
            return $this->data;
        }

        
        public function setData($data){
            $this->data = $data;
            return $this;
        }
        public function myId(){
            return $this->getId_configtaxa();
        }
        
        public function where($where){
            parent::where($where);
            return $this;
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