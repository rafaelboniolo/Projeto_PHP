<?php
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Investidor.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Pessoa.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\SessionController.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\JsonController.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\ConfigTaxa.php");
    

    class TransacaoController{
        
        public static function sacar($json){
            
            $transacao = JsonController::json_class($json, true)[0];
            $transacao->findById();

            $token = JsonController::extractToken();

            $investidor = new Investidor();
            $investidor = $investidor->findByAtributes($token['id_pessoa'])['data'][0]; /// id pessoa
          

            $format = 'Y-m-d';
            $dataSaque = DateTime::createFromFormat($format, $transacao->getDatasaque());
            $dataDeposito = DateTime::createFromFormat($format, $transacao->getData());
            $dataAtual = DateTime::createFromFormat($format, date_create()->format($format));
            
            
            $diasDeLucro   = date_diff($dataDeposito, $dataAtual)->days;

            $saldoAtual = $investidor->getSaldo();

            if($dataAtual <= $dataSaque ){
                $investidor->setSaldo($saldoAtual+($transacao->getValor()*0.01666667*$diasDeLucro)); // atualizando 0,5 do lucro para o investidor
            }else{
                $investidor->setSaldo($saldoAtual+($transacao->getValor()*0.03333333*$diasDeLucro));// 1% de lucro para o investidor
            }

            $investidor->update();
            $transacao->setDatasaque(date_create()->format($format));
            $transacao->setTipo("-");
            $transacao->setRendimento($investidor->getSaldo() - $saldoAtual);
            return $transacao->update();

        }

        
        public static function saquesDisponiveis($json){
            
            $token = JsonController::extractToken();
            
            $investidor = new Investidor();
            $investidor->setId_pessoa($token['id_pessoa']); /// id pessoa
            $investidor->findByAtributes();

            $class = JsonController::json_class($json)[0];
            $class->setId_investidor($investidor->getId_investidor());
            
            return $class->findByAtributes();
        }

        public static function depositar($json){


            $token = JsonController::extractToken();
            
            $investidor = new Investidor();
            $investidor->setId_pessoa($token['id_pessoa']); /// id pessoa
            $investidor->findByAtributes();

            $confTaxa = new ConfigTaxa();
            $confTaxa->setId_configtaxa(1)->findById();

            
            $transacao = JsonController::json_class($json, true)[0];

           
            
            $mysqlDate = explode('T', $transacao->getDataprevistasaque())[0];
            
            $transacao->setDataprevistasaque($mysqlDate);
            $transacao->setDatasaque('"+null+"');
            $transacao->setRendimento(0);
            $transacao->setId_investidor($investidor->getId_investidor());
            $transacao->setId_configtaxa($confTaxa->getId_configtaxa());
            $transacao->setData(date_create()->format('Y-m-d'));
            
            
            return JsonController::class_json($transacao->insert());
        }

    }

?>