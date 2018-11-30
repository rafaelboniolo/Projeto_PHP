<?php

require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Persistency\\Persistency.php");

class HistoricoAcao extends Persistency{

    private $id_historicoacao;
    private $id_acao;
    private $data;
    private $valor;
 
    public function getId_historicoacao()
    {
        return $this->id_historicoacao;
    }

    public function setId_historicoacao($id_historicoacao)
    {
        $this->id_historicoacao = $id_historicoacao;

        return $this;
    }

    public function getId_acao()
    {
        return $this->id_acao;
    }

    public function setId_acao($id_acao)
    {
        $this->id_acao = $id_acao;

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

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    public function myId(){
        return $this->getId_historicoacao();
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