<?php
namespace Core;

class BaseAPI {
    public $DB;
    function __construct($DB) {
        $this->DB = $DB;
    }
}