<?php
    // somente um adapter para facilitar a abertura da transação
    // é feito um encapsulamento das funções do mysqli
    // falta num_rows fetch_row (acho que não vai precisar)
    class Mysql{
        private $DATABASE='';
        private $URL='';
        private $USER='';
        private $PASSWORD='';
        
        private $mysql;

        public function open(){
            $this->mysql = new mysqli($URL, $USER, $PASSWORD, $DATABASE);
        }

        public function query($query){
            return $this->mysql->query($query);
        }

        public function close(){
            $this->myslq->close();
        }

    }
?>