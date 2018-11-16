<?php

    require_once ("C:\\xampp\\htdocs\\Projeto_PHP\\PROTECT_PROJECT.php");
    if(!PROTECTED_PROJECT::ANALYZE()) return;

class Router{
    
    private $config = [];
    private $uri;
    
    public function __construct(){
        if (isset($_SERVER['REQUEST_URI'])) {
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $this->uri = $uri;
        }
    }

    public function route($route, $callback){
        $this->config[] = ['/projeto_php/index.php'.$route => $callback];
    }

    public function run($isLogado){
        
        
        //essa parte verifica se o usuario esta logado
        // se ele nao estiver, ele so pode acessar o login
        $path = explode('/',$this->uri);
    
        if(!isset($isLogado)||$isLogado==""||!$isLogado){
            print_r(Array('error'=>'no token provider','redirect'=>'login'));
            return;
        }
            

        foreach ($this->config as $routes) {
            // print_r($routes);
           if (array_key_exists($this->uri, $routes)) {
               
                if ( is_callable($routes[$this->uri]) ) {
                    return $routes[$this->uri]();        
                }             
            }
        }
        
       http_response_code(404);
    }

}