<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(0);

use Core\Router as Router;
use Core\Database as Database;

//applico il contest di applicazione json
header('Content-Type: application/json');

require_once("conf.php");
require_once("Core/Router.class.php");
require_once("Core/Database.class.php");

// lancio la sessione
session_start();

$Router = new Router($_SERVER['REQUEST_METHOD'],$_SERVER['REQUEST_URI']);
$Database = null;

if($Router->calcolaRoute())
    $Database  = new Database(true);    

$Router->getAPIOutput($Database->DB);