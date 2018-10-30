<?php

    // ***** MODELO DE USO DO MECANISMO DE PERSISTÊNCIA *****

    include(realpath(dirname(__FILE__) ). "./Persistency/Connection.php");

    class User extends Connection{
        
        private $id;
        private $nome;
        private $dataNascimento;
        private $cpf;
        private $rg;
        private $login;
        private $senha;

        public function getId(){
            return $this->id;
        }

        public function setId($id){
            $this->id = $id;
            return $this;
        }
        public function getNome(){
            return $this->nome;
        }

        public function setNome($nome){
            $this->nome = $nome;
            return $this;
        }

        public function getDataNascimento(){
            return $this->dataNascimento;
        }

        public function setDataNascimento($dataNascimento){
            $this->dataNascimento = $dataNascimento;
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


    
    $pessoa = new User;

    //$pessoa->setNome("sdgggg")->setDataNascimento("21/04/1997")->setCpf("32132132")->setRg("54654654")->setLogin("admisadfn")->setSenha("adminasdf")->insert();

    $pessoa->setId(3)->find();


    echo $pessoa->findall()["rows"];

    //$investidor.setId($pessoa->getIdInvestidor)->find();

   ?>