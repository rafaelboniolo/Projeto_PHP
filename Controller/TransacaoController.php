<?php
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Investidor.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Pessoa.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\SessionController.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\JsonController.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\ConfigTaxa.php");
    

    class TransacaoController{
        
        public static function sacar($json){
            
            $user = SessionController::restoreUserByToken($json);

            $transacao = JsonController::json_class($json, true);
            $transacao->find();
            
            $investidor = new Investidor();
            $investidor->findByAtributes($user['id_pessoa']); /// id pessoa
            $dataSaque = $transacao->getDatasaque();

            if($dataSaque < CURRENT_DATE){
                $saldoAtual = $investidor->getSaldo();
                $investidor->setSaldo($saldoAtual+($transacao->getValor()*0.0003)); // atualizando 0,5 do lucro para o investidor, falta add 0.5 para o fundo
            }else{
                $dias = date_diff(CURRENT_DATE,  $transacao->getDatasaque());
                $investidor->setSaldo($saldoAtual+($transacao->getValor()*0.0006));// 1% de lucro para o investidor
            }

            $investidor->update();
            $transacao->setTipo("-");
            $transacao->update();

        }

        
        public static function saquesDisponiveis($json){
            
            $token = JsonController::extractToken();
            
            //$pessoa = json_decode(base64_decode($token), true);
            

            $investidor = new Investidor();
            $investidor->setId_pessoa($token['id_pessoa']); /// id pessoa

          //  print_r($json);

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

           
            
            $mysqlDate = explode('T', $transacao->getDatasaque())[0];
            
            $transacao->setDatasaque($mysqlDate);
            $transacao->setId_investidor($investidor->getId_investidor());
            $transacao->setId_configtaxa($confTaxa->getId_configtaxa());
            $transacao->setData(date_create()->format('Y-m-d'));
            
             return JsonController::class_json($transacao->insert());
        }

    }

?>