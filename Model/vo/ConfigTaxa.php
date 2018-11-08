<?php

   require_once (realpath('../../Persistency/Connection.php' ));

    class ConfigTaxa extends Connection{
        
        private $id_config_taxa;
        private $id_administrador;
        private $taxasaque;
        private $taxafundo;
        private $data;



        
        public function getId_config_taxa(){
            return $this->id_config_taxa;
        }

        
        public function setId_config_taxa($id_config_taxa){
            $this->id_config_taxa = $id_config_taxa;
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