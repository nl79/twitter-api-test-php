<?php
namespace controller;

class federal_employees extends controller {
    
    private function getDB() {
        $dsn = 'mysql:dbname=employees;host=localhost';
        $user = 'root';
        $password = 'nar1110';
        
        $db = null; 
        
        try {
            $db = new \PDO($dsn, $user, $password); 
        } catch (\PDOException $e) {
            echo('Connection Failed: ' . $e->getMessage()); 
        }
        
        return $db; 
    }
    
    public function indexAction() {
        #get the database data
        $db = $this->getDB();
        
        #load the first few employees
        $sql = 'select * from employees limit 100';
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
        
        #create a new View
        $view = new \view\federal_employees($this->_action, $stmt->fetchAll(\PDO::FETCH_ASSOC));
        
    }
}