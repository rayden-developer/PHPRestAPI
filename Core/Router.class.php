<?php
namespace Core;
use Core\Route as Route;
use Core\EchoJSON as EchoJSON;

require_once("EchoJSON.class.php");
require_once("Route.class.php");

class Router {
    
    protected $route;
    private $metodo,$uri;
    
    function __construct($metodo,$uri) {
        $this->metodo = $metodo;
        $this->uri = $uri;
        $this->route = new Route($this->esplodiUri($this->uri));
        if(!is_null($this->route->error))
            $this->generaAPIError($this->route->error);
    }
    
    public function calcolaRoute(){
        if($this->route->isRouteValida($this->metodo))
            return true;
        else 
            $this->genera404();
    }
    
    public function getAPIOutput($DB){
        try {
            header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
            header("Status: 200 OK");
            $_SERVER['REDIRECT_STATUS'] = 200;
            
            $echo = new EchoJSON(null);
            $echo-> status = true;
            $echo-> server_status = 200;
            $echo-> message = "Ok";
            $echo->set($this->route->getRouteOutput($DB));
            echo $echo -> encode();
            exit();
        } catch (\Exception $e) {
            $this->generaAPIError($this->route->error);
        }
    }
    
    private function esplodiUri($string) {
        $string = str_replace(END_POINT, '', $string);
        if ($string != "") {
            $vet = explode('/', $string);
            if (count($vet) > 1) {
                $int_value = ctype_digit($vet[1]) ? intval($vet[1]) : null;
                if ($int_value === null) {
                    return null;
                }
            }
            return $vet;
        } else
            return null;
    }
    
    private function generaAPIError($error){
        header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
        header("Status: 200 OK");
        $_SERVER['REDIRECT_STATUS'] = 200;
        
        $echo = new EchoJSON(null);
        $echo-> status = false;
        $echo-> server_status = 200;
        $echo-> message = "error ".$error;
        echo $echo-> encode();
        exit();
    }
    
    private function genera50x(){
        header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal server error");
        header("Status: 500 Internal server error");
        $_SERVER['REDIRECT_STATUS'] = 500;
        
        $echo = new EchoJSON(null);
        $echo-> status = false;
        $echo-> server_status = 500;
        $echo-> message = "error 500 Internal server error";
        echo $echo-> encode();
        exit();
    }
    
    private function genera404() {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        header("Status: 404 Not Found");
        $_SERVER['REDIRECT_STATUS'] = 404;
    
        $echo = new EchoJSON(null);
        $echo-> status = false;
        $echo-> server_status = 404;
        $echo-> message = "error 404 page not found";
        echo $echo-> encode();
        exit();
    }
}