<?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    if(!PROTECTED_PROJECT::ANALYZE()) return;


    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\protect_project.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Pessoa.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Gestor.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Acao.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\JsonController.php");
    

    class AcaoController{

        public static function comprarAcao($json){
            $token = JsonController::extractToken($json);
            
            $pessoa = new Pessoa();
            $pessoa->setCpf($token);
            $pessoa->findByAtributes();


            
            $gestor = new Gestor();
            $gestor->setId_pessoa($pessoa->getId_pessoa()); /// id pessoa
            $gestor->findByAtributes();
            
           
            
            $acoes = Array();

            foreach (JsonController::json_class($json, true) as $acao) {

                //print_r($acao);

                $acao->setId_gestor($gestor->getId_gestor())
                ->setDatacompra(date_create()->format('Y-m-d'))
                ->setDatavenda(date_create()->format('Y-m-d'))
                ->setStatus('ATIVO');

                $acao->insert();
                array_push($acoes, $acao);
            }
            

            return JsonController::class_json($acoes);
        }

        public static function listarMinhasAcoes($json){
            
            $token = JsonController::extractToken($json);
            
            $pessoa = new Pessoa();
            $pessoa->setCpf($token);
            $pessoa->findByAtributes();

            $gestor = new Gestor();
            $gestor->setId_pessoa($pessoa->getId_pessoa()); /// id pessoa
            $gestor->findByAtributes();

            $acao = JsonController::json_class($json, true);

            $acao->setId_aplicacoes($gestor->getId_aplicacoes());
            $res = $acao->findall();

            if($res['rows'] > 1)
                return JsonController::class_json($acao, 0);
            else if($res['rows'] == 1)
                return JsonController::class_json($acao);
            return;
        }

        public static function venderAcoes($json){
            
            $token = JsonController::extractToken($json);
            
            $acao = JsonController::json_class($json, true);

            $acao
            ->setDatavenda("2018-11-30")
            ->setStatus("VENDIDA")
            ->update();

            $pessoa = new Pessoa();
            $pessoa->setCpf($token);
            $pessoa->findByAtributes();

            $gestor = new Gestor();
            $gestor->setId_pessoa($pessoa->getId_pessoa()); /// id pessoa
            $gestor->findByAtributes();
                
            return JsonController::class_json($acao);
        }
    }

?>