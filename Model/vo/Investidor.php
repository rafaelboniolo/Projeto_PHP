<?php

   require_once (realpath('../../Persistency/Connection.php' ));

    class Investidor extends Connection{
        
        private $id_investidor;
        private $id_pessoa;
        private $saldo;


        public function getId_investidor(){
            return $this->id_investidor;
        }

        public function setId_investidor($id_investidor){
            $this->id_investidor = $id_investidor;
            return $this;
        }

        public function getId_pessoa(){
            return $this->id_pessoa;
        }

        
        public function setId_pessoa($id_pessoa){
            $this->id_pessoa = $id_pessoa;
            return $this;
        }

        public function getSaldo(){
            return $this->saldo;
        }

        public function setSaldo($saldo){
            $this->saldo = $saldo;
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