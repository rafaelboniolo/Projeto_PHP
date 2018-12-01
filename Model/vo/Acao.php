<?php
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    if(!PROTECTED_PROJECT::ANALYZE()) return;

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Persistency\\Persistency.php");

class Acao extends Persistency{

    private $id_acao;
    private $id_gestor;
    private $valorvenda;
    private $descricao;
    private $tipo;
    private $rendimento;
    private $status;
    private $valorcompra;
    private $datacompra;
    private $datavenda;

    public function getId_acao()
    {
        return $this->id_acao;
    }

    public function setId_acao($id_acao)
    {
        $this->id_acao = $id_acao;

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

    public function getValorvenda()
    {
        return $this->valorvenda;
    }

    public function setValorvenda($valorvenda)
    {
        $this->valorvenda = $valorvenda;

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

    public function getValorcompra()
    {
        return $this->valorcompra;
    }

    public function setValorcompra($valorcompra)
    {
        $this->valorcompra = $valorcompra;

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