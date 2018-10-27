<?php
    // somente um adapter para facilitar a abertura da transação
    // é feito um encapsulamento das funções do mysqli
    // falta num_rows fetch_row (acho que não vai precisar)
    //include(realpath(dirname(__FILE__) )."\\Util.php");

    class Mysql{
        
        
        // private $DATABASE='teste01';
        // private $URL='localhost';
        // private $USER='root';
        // private $PASSWORD='1234';
        
        
        private $URL;
        private $USER;
        private $PASSWORD;
        private $mysql;
        
        
        public function getConfigMysql(){
            $mysqlData = Util::configMYSQL();
           
            $this->DATABASE = $mysqlData["NAME"];
            $this->URL = $mysqlData["URL"];
            $this->USER = $mysqlData["USER"];
            $this->PASSWORD = $mysqlData["PASSWD"];  
        
        }
        
         
        public function open(){
            $this->getConfigMysql();
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