<?php

class Router
{
    private $config = [];
    private $uri;
    
    public function __construct(){
        if (isset($_SERVER['REQUEST_URI'])) {
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $this->uri = $uri;
        }
    }

    public function route($route, $callback){
        $this->config[] = ['/Projeto_PHP/index.php'.$route => $callback];
    }

    public function run($noRedirect){
        
        $path = explode('/',$this->uri);
        foreach ($path as $key => $value) {
            if($value == 'login')
                $noRedirect = true;
        }
        if(!isset($noRedirect)||$noRedirect==""){
            print_r(Array('error'=>'no token provider'));
            return;
        }
            

        foreach ($this->config as $routes) {
           if (array_key_exists($this->uri, $routes)) {
                if ( is_callable($routes[$this->uri]) ) {
                    return $routes[$this->uri]();        
                }             
            }
        }
        
       http_response_code(404);
    }

}