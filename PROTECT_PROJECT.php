<?php
    class PROTECTED_PROJECT{
        public static function ANALYZE(){
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            
            $permission = false;

            foreach (explode('/', $uri) as $key => $value) {
                if($value == 'index.php')
                    $permission = true;
            }

            if(!$permission){
                print_r(json_encode(Array("SAFADO"=>"Onde pensa que vai garotinho???")));
                http_response_code(401);
            }
            return $permission;
        }    
    }
    

?>