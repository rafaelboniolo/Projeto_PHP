<?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    if(!PROTECTED_PROJECT::ANALYZE()) return;

    // somente um adapter para facilitar a abertura da transação
    // é feito um encapsulamento das funções do mysqli
    class ConnectionMysql{
        
        
        private $URL;
        private $USER;
        private $PASSWORD;
        private $mysql;
        
        private function seetConfigMysql(){
            $mysqlData = DatabaseUtil::configMYSQL();
           
            $this->DATABASE = $mysqlData["NAME"];
            $this->URL = $mysqlData["URL"];
            $this->USER = $mysqlData["USER"];
            $this->PASSWORD = $mysqlData["PASSWD"];  
        }
        
         
        public function open(){
            $this->seetConfigMysql();
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