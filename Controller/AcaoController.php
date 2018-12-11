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
            $token = JsonController::extractToken();
            
            $id_pessoa = $token['id_pessoa'];
            
            
            $gestor = new Gestor();
            $gestor->setId_pessoa($id_pessoa); /// id pessoa
            $gestor->findByAtributes();
            
            

            $acao = JsonController::json_class($json, true)[0];

            $acao->setId_gestor($gestor->getId_gestor())
            ->setDatacompra(date_create()->format('Y-m-d'))
            ->setDatavenda('"+null+"')
            ->setStatus('ATIVO');
            
            $acao->insert();

            return JsonController::class_json($acao);
        }

        public static function listarMinhasAcoes($json){
            
            $token = JsonController::extractToken();
            
            $id_pessoa = $token['id_pessoa'];
            
            
            $gestor = new Gestor();
            $gestor->setId_pessoa($id_pessoa); /// id pessoa
            $gestor->findByAtributes();
            
            $acao = JsonController::json_class($json, true)[0];
            $acao->setId_gestor($gestor->getId_gestor());


            return $acao->findByAtributes()['data'];

        }

        public static function venderAcoes($json){
            
            $token = JsonController::extractToken($json);
            
            $acao = JsonController::json_class($json, true)[0];

            $pessoa = new Pessoa();
            $pessoa->setId_pessoa($token['id_pessoa']);
            $pessoa->findByAtributes();

            $acao2 = new Acao();

            
            $gestor = new Gestor();
            $gestor->setId_pessoa($pessoa->getId_pessoa()); /// id pessoa
            $gestor->findByAtributes();
            
            $acao2 = $acao2
            ->setId_gestor($gestor->getId_gestor())
            ->setStatus('ATIVO')
            ->findByAtributes()['data'][0];
            
            if($acao2->getId_acao() == ""){
                http_response_code(404);
                return Array("erro"=>"nao existe acoes para estas configuracoes");
            }

            $acao2
            ->setDatavenda(date_create()->format('Y-m-d'))
            ->setValorvenda($acao->getValorvenda())
            ->setRendimento($acao->getValorvenda() - $acao2->getValorcompra())
            ->setStatus("VENDIDA")
            ->update();
            
            return JsonController::class_json($acao);
        }
    }

?>