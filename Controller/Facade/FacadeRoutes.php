<?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    if(!PROTECTED_PROJECT::ANALYZE()) return;

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\JsonController.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\SessionController.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\ControllerConfig\\AuthController.php");

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\TransacaoController.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\AcaoController.php");
    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\Controller\\AdministracaoController.php");


    
    class FacadeRoutes{

        public static function login($json){

            $user = json_decode($json,true)[0];
            
            $sessionData = AuthController::authenticate($user['login'], $user['password']);    
             if($sessionData['token']==''){
                print_r(json_encode(Array('error'=>'login ou senha invalida')));
                http_response_code(400);
             }
    
            http_response_code(200);

    
            print_r(json_encode(Array('token'=>$sessionData['token'], 'user'=>$sessionData['user'])));
        }

        public static function logout($json){
            // $token = JsonController::extractToken($json);
            // SessionController::close($token);
        } 

        public static function insert($json){
           
            $classes = JsonController::json_class($json);

            $jsonClasses = Array();

            
            foreach ($classes as $class) {
                    $class->insert();
                    if($class->myId()!=""){
                        http_response_code(200);
                        array_push($jsonClasses, $class);
                    }else{
                        http_response_code(400);
                        print_r($json);
                        print_r(json_encode(Array("error"=>"insert error")));
                    }
                }
                
            print_r(json_encode(JsonController::class_json($jsonClasses)));

        }

        public static function update($json){
            $class = JsonController::json_class($json,true);
            $class->update();

            http_response_code(200);
        }
        
        public static function delete($json){
            $class = JsonController::json_class($json, true);
            $class->delete();
        }
        
        public static function findById($json){
            $class = JsonController::json_class($json, true);
            $class->findById();

            print_r(json_encode(Array("config"=>JsonController::getConfig(),"dados"=>JsonController::class_json($class))));
            http_response_code(200);
            
        }

        public static function findByAtributes($json){
            $class = JsonController::json_class($json, true);
            $res = $class->findByAtributes();



            if($res['rows'] == 0){
                http_response_code(404);
                return;
            }

            $arrayDados = Array();

            $i=1;
            foreach ($res['data'] as $dados) {
               $arrayDados[$i] = JsonController::class_json($dados, 0);
                $i++;
            }

            print_r(json_encode(Array("config"=>JsonController::getConfig($class, $i),"dados"=>$arrayDados)));
        }
        
        public static function findAll($json){
           
            $class = JsonController::json_class($json)[0];
            
            $res = $class->findall();

            if($res['rows'] == 0){
                http_response_code(404);
                return;
            }

            print_r(json_encode(JsonController::class_json(($res['data']))));
        }

        
        public static function sacar($json){
            $res = TransacaoController::sacar($json);
            print_r(json_encode($res));
        }

        public static function saquesDisponiveis($json){
            $class = JsonController::instanceClass();
            $res = TransacaoController::saquesDisponiveis($json);
            

            
             if($res['rows'] == 0){
                 http_response_code(404);
                 return;
             }

             
            $arrayDados= JsonController::class_json($res['data']);

            print_r(json_encode($arrayDados));

        }

        

        public static function depositar($json){
            
            $res = TransacaoController::depositar($json);

            print_r(json_encode(Array($res)));
        }


        public static function comprarAcao($json){
            $acao = AcaoController::comprarAcao($json);
            print_r(json_encode(Array($acao)));
        }





        public static function listarMinhasAcoes($json){

            $acoes = AcaoController::listarMinhasAcoes($json);
            print_r(json_encode(JsonController::class_json($acoes)));
        }

        public static function venderAcoes($json){
     
            $acao = AcaoController::venderAcoes($json);
            print_r(json_encode($acao));
        }


        public static function fundoDisponivel($json){
            $total = AdministracaoController::fundoDisponivel($json);
            print_r(json_encode($total));
        }

        public static function ganhosTotais($json){
           
            $total = AdministracaoController::ganhosTotais($json);
           
            print_r(json_encode($total));
        }
        
        public static function dadosGestor($json){
           
            $res = PessoaController::dadosGestor($json);
            print_r(json_encode($res));

        }

        

        

    }
?>