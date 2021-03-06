<?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    if(!PROTECTED_PROJECT::ANALYZE()) return;

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Persistency\\Persistency.php");

    class Pessoa extends Persistency {

        const ADM = 'ADM';
        const INV = 'INV';
        const GES = 'GES';

        private $id_pessoa;
        private $nome;
        private $email;
        private $cpf;
        private $rg;
        private $login;
        private $senha;
        private $tipo;

       
        public function getId_pessoa(){
            return $this->id_pessoa;
        }

        public function setId_pessoa($id_pessoa){
            $this->id_pessoa = $id_pessoa;
            return $this;
        }

        public function getNome(){
            return $this->nome;
        }

        public function setNome($nome){
            $this->nome = $nome;
            return $this;
        }
        public function getEmail(){
            return $this->email;
        }

        public function setEmail($email){
            $this->email = $email;
            return $this;
        }

        
        public function getCpf(){
           return $this->cpf;
        }

        public function setCpf($cpf){
            $this->cpf = $cpf;
            return $this;
        }

        public function getRg(){
            return $this->rg;
        }

        public function setRg($rg){
            $this->rg = $rg;
            return $this;
        }

        public function getLogin(){
            return $this->login;
        }

        public function setLogin($login){
            $this->login = $login;
            return $this;   
        }

       
        public function getSenha(){
            return $this->senha;
        }

        public function setSenha($senha){
            $this->senha = $senha;
            return $this;
        }

        public function getTipo(){
            return $this->tipo;
        }

        public function setTipo($tipo){
            $this->tipo = $tipo;
            return $this;
        }

        public function myId(){
            return $this->getId_pessoa();
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