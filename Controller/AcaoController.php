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

           // print_r($acao);

            $acao[0]->setId_gestor($gestor->getId_gestor());
            $res = $acao[0]->findall();

            //print_r($res);

            if($res['rows'] > 1)
                return Array("rows"=>$res['rows'], "data"=>JsonController::class_json($res['data']));
            else if($res['rows'] == 1)
                return Array("rows"=>$res['rows'], JsonController::class_json($res['data'][0]));
            return;
        }

        public static function venderAcoes($json){
            
            $token = JsonController::extractToken($json);
            
            $acao = JsonController::json_class($json, true);

            print_r($acao);
            
            $acao
            ->setDatavenda(date_create()->format('Y-m-d'))
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