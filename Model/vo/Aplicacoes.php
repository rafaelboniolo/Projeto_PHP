<?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Persistency\\Persistency.php");

    class Aplicacoes extends Persistency{

        private $id_aplicacoes;
        private $id_gestor;
        private $datacompra;
        private $datavenda;
        private $status;

        public function getId_aplicacoes()
        {
                return $this->id_aplicacoes;
        }

         public function setId_aplicacoes($id_aplicacoes)
        {
                $this->id_aplicacoes = $id_aplicacoes;

                return $this;
        }

        public function getId_gestor()
        {
                return $this->id_gestor;
        }

        public function setId_gestor($id_gestor)
        {
                $this->id_gestor = $id_gestor;

                return $this;
        }

        public function getDatacompra()
        {
                return $this->datacompra;
        }

        public function setDatacompra($datacompra)
        {
                $this->datacompra = $datacompra;

                return $this;
        }

        public function getDatavenda()
        {
                return $this->datavenda;
        }

        public function setDatavenda($datavenda)
        {
                $this->datavenda = $datavenda;

                return $this;
        }

        public function getStatus()
        {
                return $this->status;
        }
 
        public function setStatus($status)
        {
                $this->status = $status;

                return $this;
        }

        public function myId(){
            return $this->getId_aplicacoes();
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