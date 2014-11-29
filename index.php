<?php

#set errors reporting
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

date_default_timezone_set('America/New_York');

require_once('library/loader.class.php'); 
spl_autoload_register('library\\loader::load', true); 

//get the page from the request.
$page = 'index';
if(isset($_REQUEST['page']) && is_string($_REQUEST['page']) && !empty($_REQUEST['page'])) {
    $page = $_REQUEST['page']; 
}

$page = 'controller\\' . $page;
/*
 *Try to load the extension class.
 *If fails, load the error class.
 */
try {
    $controller = new $page();
} catch (Exception $e) {
    $controller = new controller\error(); 
    //echo($e->getMessage()); 
   
}

#$controller = new controller\index();
#load the twitter controller.
#$controller = new controller\twitter(); 
