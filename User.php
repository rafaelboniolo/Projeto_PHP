<?php

    // ***** MODELO DE USO DO MECANISMO DE PERSISTÊNCIA *****

   require_once (realpath(dirname(__FILE__) ). "\\Model\\vo\Pessoa.php");
   require_once (realpath(dirname(__FILE__) ). "\\Model\\vo\Investidor.php");
   

     $p1 = new Pessoa();

    // $p1
    //     ->setNome("Rafael Boniolo investidor")
    //     ->setCpf("10326399976")
    //     ->setRg("126718047")
    //     ->setLogin("testeLogin")
    //     ->setSenha("testeSenha")
    //     ->setTipo(Pessoa::INV)
    //     ->insert();


    // $i1 = new Investidor();

    // $i1->setId_pessoa($p1->getId_pessoa())->setSaldo("9762397.039")->insert();

    $a = $p1->findall()["data"];

    foreach ($a as $key) {
        echo $key->getNome();
    }

   ?>