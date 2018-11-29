<?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    if(!PROTECTED_PROJECT::ANALYZE()) return;

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Persistency\\Persistency.php");

    class Transacao extends Persistency {

        const ATIVO = 'ATIVO';
        const INATIVO = 'INATIVO';

        const DEPOSITO = '+';
        const SAQUE = '-';

        private $id_transacao;
        private $id_investidor;
        private $id_configtaxa;
        private $tipo;
        private $data;
        private $valor;
        private $status;
        private $datasaque;
         
/**
         * Get the value of id_transacao
         */ 
        public function getId_transacao()
        {
                return $this->id_transacao;
        }

        /**
         * Set the value of id_transacao
         *
         * @return  self
         */ 
        public function setId_transacao($id_transacao)
        {
                $this->id_transacao = $id_transacao;

                return $this;
        }

        /**
         * Get the value of id_investidor
         */ 
        public function getId_investidor()
        {
                return $this->id_investidor;
        }

        /**
         * Set the value of id_investidor
         *
         * @return  self
         */ 
        public function setId_investidor($id_investidor)
        {
                $this->id_investidor = $id_investidor;

                return $this;
        }

        /**
         * Get the value of id_configtaxa
         */ 
        public function getId_configtaxa()
        {
                return $this->id_configtaxa;
        }

        /**
         * Set the value of id_configtaxa
         *
         * @return  self
         */ 
        public function setId_configtaxa($id_configtaxa)
        {
                $this->id_configtaxa = $id_configtaxa;

                return $this;
        }

        /**
         * Get the value of tipo
         */ 
        public function getTipo()
        {
                return $this->tipo;
        }

        /**
         * Set the value of tipo
         *
         * @return  self
         */ 
        public function setTipo($tipo)
        {
                $this->tipo = $tipo;

                return $this;
        }

        /**
         * Get the value of data
         */ 
        public function getData()
        {
                return $this->data;
        }

        /**
         * Set the value of data
         *
         * @return  self
         */ 
        public function setData($data)
        {
                $this->data = $data;

                return $this;
        }

        /**
         * Get the value of valor
         */ 
        public function getValor()
        {
                return $this->valor;
        }

        /**
         * Set the value of valor
         *
         * @return  self
         */ 
        public function setValor($valor)
        {
                $this->valor = $valor;

                return $this;
        }

        /**
         * Get the value of status
         */ 
        public function getStatus()
        {
                return $this->status;
        }

        public function setStatus($status)
        {
                $this->status = $status;

                return $this;
        }

        public function getDatasaque()
        {
                return $this->datasaque;
        }

        public function setDatasaque($datasaque)
        {
                $this->datasaque = $datasaque;

                return $this;
        }



        public function myId(){
            return $this->getId_transacao();
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
