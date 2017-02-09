<?php
namespace Core;

class Route {
    public $error;
    protected $metodo,$apiName,$apiArgs;
    
    function __construct($args) {
        $this->apiArgs = array();
        if(!is_null($args) && is_array($args)){
            $this->apiName = $args[0];
            unset($args[0]);
            $this->apiArgs = array_values($args);
        }else{
            $this->error = 'API Error - chiamata non interpretabile';
        }
    }
    
    public function isRouteValida($metodo){
        $this->metodo = $metodo;
        
        /*
         * METODI ACCETTABILI GET, POST, PUT, DELETE
         *  GET lettura del dato,
         *  POST inserimento di un nuovo dato,
         *  PUT modifica di un dato esistente e
         *  DELETE per la cancellazione del dato.
         *
         */
        
        switch ($this->metodo){
            case 'GET':
            case 'POST':
            case 'PUT':
            case 'DELETE':
                return $this->checkRoute();
            break;
            default:
                return false;
            break;
        }
        //se 404
        return false;
    }
    
    private function checkRoute(){  
        if(isset($this->metodo) && isset($this->apiName)){
            //Controllo che esista il file della API
             if(file_exists("API/".ucfirst($this->apiName).".API.php")){
                 require_once ("API/".ucfirst($this->apiName).".API.php");
                  //Controllo che il metodo HTTP richiesto esista
                  if(method_exists(ucfirst($this->apiName), $this->metodo)){
                      return true;
                  }
             }
        }
        
        return false;
    }
    
    public function getRouteOutput($DB){
        require_once ("API/".ucfirst($this->apiName).".API.php");
        $name= ucfirst($this->apiName);
        $API = new $name($DB);
        return $API->{$this->metodo}($this->apiArgs);        
    }
}