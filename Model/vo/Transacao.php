  <?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    if(!PROTECTED_PROJECT::ANALYZE()) return;

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Persistency\\Persistency.php");

    class Transacao extends Persistency{
        
        private $id_transacao;
        private $id_investidor;
        private $id_configtaxa;
        private $tipo;
        private $data;
        private $valor;
        private $status;
        private $datasaque;
        private $dataprevistasaque;
        private $rendimento;
        
        public function getId_transacao()
        {
                return $this->id_transacao;
        }

        public function setId_transacao($id_transacao)
        {
                $this->id_transacao = $id_transacao;

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

        public function getId_configtaxa()
        {
                return $this->id_configtaxa;
        }

        public function setId_configtaxa($id_configtaxa)
        {
                $this->id_configtaxa = $id_configtaxa;

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

        
        public function getDataprevistasaque()
        {
                return $this->dataprevistasaque;
        }

        public function setDataprevistasaque($dataprevistasaque)
        {
                $this->dataprevistasaque = $dataprevistasaque;

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

        public function where($where){
            parent::where($where);
        }
        public function groupBy($groupBy){
            parent::groupBy($groupBy);
        }
    }
    


?>
