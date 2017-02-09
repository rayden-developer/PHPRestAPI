<?php
use Core\BaseAPI as BaseAPI;
use Core\iAPI as iAPI;

require_once("Core/BaseAPI.class.php");
require_once("Core/iAPI.interface.php");

class Giocatore extends BaseAPI implements iAPI{
    
    public $DB;
    
    public function GET($arg) {
        //var_dump($this->DB);
        //exit;
        $stm = $this->DB->prepare("SELECT * FROM Giocatori WHERE ID = ?;");
        $stm->execute([$arg[0]]);
        $out = $stm->fetchAll(\PDO::FETCH_ASSOC);
        
        return ["Api" =>"Giocatore->GET" , "Args"=>$arg, "Output"=>$out];
    }
    
    public function POST($args){}
    public function PUT($args){}
    public function DELETE($args){}
}