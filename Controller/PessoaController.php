<?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    if(!PROTECTED_PROJECT::ANALYZE()) return;


    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\protect_project.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Pessoa.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Acao.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Gestor.php");

    class PessoaController{

        
        public static function authenticate($login, $password){
        
            $user = new Pessoa();

            $res = $user
                    ->setLogin($login)
                    ->setSenha($password)
                    ->findByAtributes();
                    
            if($res['rows'] != 1) return false;

            return $user;
        }

        public static function dadosGestor($json){
            $pessoa = JsonController::instanceClass();

            $gestor = new Gestor();
            $gestor->setId_pessoa($pessoa->getId_pessoa());
            $gestor = $gestor->findByAtributes()['data'][0];

            $meta = $gestor->getMeta();

            $acao = new Acao();
            $acao->setId_gestor($gestor->getId_gestor());
            $acao->setStatus("VENDIDA");
            $acoes = $acao->findByAtributes()['data'];
            
            $lucroAtual = 0;
            $fundoAtual = $gestor->getGiromaximo();

            foreach ($acoes as $acao) {
                $lucroAtual+= $acao->getRendimento();
            }

            $fundoAtual = $gestor->getGiromaximo() + $lucroAtual;
            
            $acao = new Acao();
            $acao->setId_gestor($gestor->getId_gestor());
            $acao->setStatus("ATIVO");
            $acoes = $acao->findByAtributes()['data'];
            
            
            foreach ($acoes as $acao) {
                $fundoAtual-= $acao->getValorcompra();
            }


            return (Array("fundoatual"=>$fundoAtual, "lucroatual"=>$lucroAtual, "meta"=>$meta));
        }
        
    }

?>