<?php
    // ***** MODELO DE USO DO MECANISMO DE PERSISTÊNCIA *****

    require_once (realpath(dirname(__FILE__) ). "\\Model\\vo\\Pessoa.php");

    $p1 = new Pessoa();

    $p1
        ->setNome("teste")
        ->setEmail("asasas")
        ->setCpf("teste")
        ->setRg("teste")
        ->setLogin("teste")
        ->setSenha("teste")
        ->setTipo(Pessoa::INV)
        ->insert();

    
   ?>