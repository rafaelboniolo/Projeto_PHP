<?php
    // somente um adapter para facilitar a abertura da transação
    // é feito um encapsulamento das funções do mysqli
    // falta num_rows fetch_row (acho que não vai precisar)
    class Mysql{
        private $DATABASE='teste02';
        private $URL='localhost';
        private $USER='root';
        private $PASSWORD='cdanlj78';
        
        private $con;

        private $mysql;



         
// seleciona a base de dados em que vamos trabalhar

        public function open(){
           // $this->con = mysql_pconnect($this->URL, $this->USER, $this->PASSWORD) or trigger_error(mysql_error(),E_USER_ERROR);
            //mysql_select_db($this->DATABASE, $this->con);
            $this->mysql = new mysqli($this->URL, $this->USER, $this->PASSWORD, $this->DATABASE);
            return $this;
        }

        public function query($query){
            //$dados = mysql_query($query, $this->con) or die(mysql_error());
            //return mysql_fetch_assoc($dados);
            return $this->mysql->query($query);
        }

        public function close_(){
            $this->myslq->close();
            return $this;
        }

    }
?>