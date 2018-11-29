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