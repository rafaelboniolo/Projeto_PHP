<?php
    // somente um adapter para facilitar a abertura da transação
    // é feito um encapsulamento das funções do mysqli
    // falta num_rows fetch_row (acho que não vai precisar)
    class Mysql{
        private $DATABASE='teste01';
        private $URL='localhost';
        private $USER='root';
        private $PASSWORD='1234';
        
        private $mysql;
         
        public function open(){
            $this->mysql = new mysqli($this->URL, $this->USER, $this->PASSWORD, $this->DATABASE);
            return $this;
        }

        public function query($query){
            return $this->mysql->query($query);
        }

        public function close(){
            $this->mysql->close();
        }

    }
?>