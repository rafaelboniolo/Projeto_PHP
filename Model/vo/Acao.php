<?php

class Acao extends Persystency{

    private $id_acao;
    private $id_aplicacoes;
    private $valor;
    private $descricao;
    private $tipo;
    private $rendimento;
    private $status;
    private $valor_compra;

    public function getId_acao()
    {
        return $this->id_acao;
    }

    public function setId_acao($id_acao)
    {
        $this->id_acao = $id_acao;

        return $this;
    }

    public function getId_aplicacoes()
    {
        return $this->id_aplicacoes;
    }

    public function setId_aplicacoes($id_aplicacoes)
    {
        $this->id_aplicacoes = $id_aplicacoes;

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

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getRendimento()
    {
        return $this->rendimento;
    }

    public function setRendimento($rendimento)
    {
        $this->rendimento = $rendimento;

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

    public function getValor_compra()
    {
        return $this->valor_compra;
    }

    public function setValor_compra($valor_compra)
    {
        $this->valor_compra = $valor_compra;

        return $this;
    }

    public function myId(){
        return $this->getId_acao();
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