<?php

    // ***** MODELO DE USO DO MECANISMO DE PERSISTÊNCIA *****

  //  require_once (realpath(dirname(__FILE__) ). "\\Model\\vo\\Pessoa.php");
  //  require_once (realpath(dirname(__FILE__) ). "\\Model\\vo\\Investidor.php");
   require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\JsonController.php");   

    //  $p1 = new Pessoa();

    // $p1
    //     ->setNome("teste")
    //     ->setEmail("asasas")
    //     ->setCpf("teste")
    //     ->setRg("teste")
    //     ->setLogin("teste")
    //     ->setSenha("teste")
    //     ->setTipo(Pessoa::INV)
    //     ->insert();

    $format = 'Y-m-d';
    // $date = DateTime::createFromFormat($format, '2009-02-15');
    // $datew = DateTime::createFromFormat($format, '2018-02-15');
    

    // echo(date_diff($date, $datew)->days);

    print_r(date_create()->format($format));

  //   //JsonController::class_json($p1,0);
  //   // //     $p1 = new Pessoa();

  //   // echo($p1->setNome("teste")->findByAtributes())['data']->getNome();

  //   // $p1 = new Pessoa();

  //   //echo $p1->setId_pessoa(3)->findById()->getNome();

    

  //   // $i1 = new Investidor();

  //   // $i1->setId_pessoa($p1->getId_pessoa())->setSaldo("9762397.039")->insert();
  //   // teste...


    
    // echo $_SERVER['HTTP_BEARER'];
    echo base64_encode('{id:10}');
    
   ?>