<?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    if(!PROTECTED_PROJECT::ANALYZE()) return;

    // somente um adapter para facilitar a abertura da transação
    // é feito um encapsulamento das funções do mysqli
    class ConnectionMysql{
              
         
        public static function query($query){
            $mysqlData = DatabaseUtil::configMYSQL();
            $mysql = new mysqli($mysqlData["URL"], $mysqlData["USER"], $mysqlData["PASSWD"], $mysqlData["NAME"]);
            $data = $mysql->query($query);
            $id = $mysql->insert_id;
            $mysql->close();
        
            return Array("data"=>$data, "id"=> $id); 
        }

        

    }
?>