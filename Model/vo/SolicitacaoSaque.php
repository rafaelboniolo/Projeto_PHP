<?php

require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Persistency\\Persistency.php");


class SolicitacaoSaque extends Persistency{

    private $id_solicitacaosaque;
    private $id_investidor;
    private $valor;
    private $data;
    private $status;

    public function getId_solicitacaosaque()
    {
        return $this->id_solicitacaosaque;
    }

    public function setId_solicitacaosaque($id_solicitacaosaque)
    {
        $this->id_solicitacaosaque = $id_solicitacaosaque;

        return $this;
    }

    public function getId_investidor()
    {
        return $this->id_investidor;
    }

    public function setId_investidor($id_investidor)
    {
        $this->id_investidor = $id_investidor;

        return $this;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;

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
        return $this->getId_solicitacaosaque();
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