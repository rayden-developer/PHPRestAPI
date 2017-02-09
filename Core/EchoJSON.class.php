<?php
namespace Core;

class EchoJSON {
    
    private $data = array();
    public $status = true;
    public $server_status = 200;
    public $message = '';
    
    function __construct($data = null) {
        if (isset($data))
            $this -> data[] = $data;
    }
    
    public function set($data) {
        $this -> data[] = $data;
    }
    
    public function rimuovi($data) {
        if (isset($this -> data[$data]))
            unset($this -> data[$data]);
    
    }
    
    public function encode() {
    
        $out = array(
            array(
                "status" => $this -> status, 
                "server_status" => $this -> server_status, 
                "message" => $this -> message, 
                "data" => $this -> data
            )  
        );
//         $temp[] = array(
//             'status' => $this -> status, 
//             "server_status" => $this -> server_status, 
//             "message" => $this -> message, 
//             "data" => $this -> data
//         );
        return json_encode($out);
    }
    
}