<?php

    // ***** MODELO DE USO DO MECANISMO DE PERSISTÊNCIA *****

   require_once (realpath(dirname(__FILE__) ). "\\Model\\vo\\Pessoa.php");
   require_once (realpath(dirname(__FILE__) ). "\\Model\\vo\\Investidor.php");
   

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

    // //     $p1 = new Pessoa();

    // echo($p1->setNome("teste")->findByAtributes())['data']->getNome();

    // $p1 = new Pessoa();

    //echo $p1->setId_pessoa(3)->findById()->getNome();

    

    // $i1 = new Investidor();

    // $i1->setId_pessoa($p1->getId_pessoa())->setSaldo("9762397.039")->insert();
    // teste...
   ?>
   