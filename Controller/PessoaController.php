<?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    if(!PROTECTED_PROJECT::ANALYZE()) return;


    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\protect_project.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Model\\vo\\Pessoa.php");

    class PessoaController{

        
        public static function authenticate($login, $password){
        
            $user = new Pessoa();

            $res = $user
                    ->setLogin($login)
                    ->setSenha($password)
                    ->findByAtributes();
                    
            if($res['rows'] != 1) return false;

            //findByAtributes retorna um array de rows e data
            // porem como soh temos 1 usuario, n precisamos acessar pelo user['data'], pq alem de retornar o array, ele chama o popula
            // ou seja, $user['rows'] =  1, $user['data'] = $user, podemos omitir o 'data' neste caso
            return $user;
        }

    }

?>