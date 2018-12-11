<?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    if(!PROTECTED_PROJECT::ANALYZE()) return;


    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\protect_project.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Pessoa.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Gestor.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Acao.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\JsonController.php");
    

    class AdministracaoController{

        public static function fundodisponivel($json){
            $transacao = JsonController::instanceClass();

            $transacoes = $transacao
                ->setTipo("+")
                ->findByAtributes()['data'];

            $total = 0;    
            foreach ($transacoes as $transacao) {
                $total += $transacao->getValor();
            }

            return Array('total'=>$total);
        }


        public static function ganhosTotais(){
            $acao = JsonController::instanceClass();

            $acoes=$acao
            ->setStatus("VENDIDA")
            ->findByAtributes()['data'];

            $ganhos = Array();

            foreach ($acoes as $acao) {
                $mes = explode("-", $acao->getDatacompra())[1];

                if(!isset($ganhos["$mes"]))
                    $ganhos["$mes"] = 0;

                $ganhos["$mes"] += $acao->getRendimento();
                
            }
             return $ganhos;

        }
    }

?>