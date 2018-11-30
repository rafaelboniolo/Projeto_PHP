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
            
            $token = JsonController::extractToken($json);
            
            $pessoa = new Pessoa();
            $pessoa->setCpf($token);
            $pessoa->findByAtributes();

            $investidor = new Investidor();
            $investidor->setId_pessoa($pessoa->getId_pessoa()); /// id pessoa
            $investidor->findByAtributes();

            $transacao = JsonController::json_class($json, true);
            $transacao->setId_investidor($investidor->getId_investidor());
            
            
            return $transacao->findByAtributes();
        }

        public static function depositar($json){
            $token = JsonController::extractToken($json);
            
            $pessoa = new Pessoa();
            $pessoa->setCpf($token);
            $pessoa->findByAtributes();

            $investidor = new Investidor();
            $investidor->setId_pessoa($pessoa->getId_pessoa()); /// id pessoa
            $investidor->findByAtributes();

            //$confTaxa = new ConfigTaxa();
            //$confTaxa->findall();

            $transacao = JsonController::json_class($json, true);
            $transacao->setId_investidor($investidor->getId_investidor());
            $transacao->setId_configtaxa(3);

            
            return $transacao->insert();
        }

    }

?>