<?php

    // ***** MODELO DE USO DO MECANISMO DE PERSISTÊNCIA *****

    // toda classe de Value Object deve extender a classe connection e fazer um adapter para o super (parent::)
    // desta forma o objeto ira fazer as operações em si proprio
    // falta popular o objeto com os dados do select e extrair os dados dele para o insert

    //asasas


    include(realpath(dirname(__FILE__) ). "./Persistency/Database/Connection.php");

    class User extends Connection{
        
        private $id;
        private $nome;
        // private $dataNascimento;
        // private $cpf;
        // private $rg;
        // private $login;
        // private $senha;

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

        // public function getDataNascimento(){
        //     return $this->dataNascimento;
        // }

        // public function setDataNascimento($dataNascimento){
        //     $this->dataNascimento = $dataNascimento;
        //     return $this;
        // }

        // public function getCpf(){
        //     return $this->cpf;
        // }

        // public function setCpf($cpf){
        //     $this->cpf = $cpf;
        //     return $this;
        // }

        // public function getRg(){
        //     return $this->rg;
        // }

        // public function setRg($rg){
        //     $this->rg = $rg;
        //     return $this;
        // }

        // public function getLogin(){
        //     return $this->login;
        // }

        // public function setLogin($login){
        //     $this->login = $login;
        //     return $this;
        // }

        // public function getSenha(){
        //     return $this->senha;
        // }

        // public function setSenha($senha){
        //     $this->senha = $senha;
        //     return $this;
        // }


        public function find(){
            parent::find_($this);
        }

        public function insert(){
            parent::insert_($this);
        }

        public function update(){

        }

        public function delete(){
            return parent::delete_($this);
        }

    }

    
    $user = new User;

    $user->setId(2);
    //$user->setNome("matheus");

   // $user->insert();

    $user->find();
    echo $user->getNome();

    $user->delete();
    echo $user->getNome();

   
?>