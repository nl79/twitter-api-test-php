<?php
namespace controller;

class error extends controller {
    
    public function indexAction() {
        echo("Error - Page Not Found"); 
    }
    
    public function defaultAction($args) {
        echo("Error - Page Not Found ");
        var_dump($args); 
    }
}