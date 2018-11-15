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

    public function run($redirect = false){
        
        if(!isset($redirect))
            return $this->config['/Projeto_PHP/index.php/login']();

        foreach ($this->config as $routes) {
           if (array_key_exists($this->uri, $routes)) {
                if ( is_callable($routes[$this->uri]) ) {
                    print_r($routes);   
                    return $routes[$this->uri]();        
                }             
            }
        }
        
       http_response_code(404);
    }

}