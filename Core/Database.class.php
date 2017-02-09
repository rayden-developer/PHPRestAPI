<?php
namespace Core;

class Database {
    
    public $DB;
    
    function __construct($OpenConnection = false) {
        if(isset($OpenConnection))
            return $this->open();
    }
    
    private function open(){
        try {
            $options = array(
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_EMULATE_PREPARES => false,
            );

            $this->DB = new \PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME."", DB_USERNAME, DB_PASSWORD, $options);

        } catch (\PDOException $e) {
            exit;($e->getMessage());
        }  
        return 0;
    }
}