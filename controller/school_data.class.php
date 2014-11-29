<?php
namespace controller;

class school_data extends controller {
    
    private function getDB() {
        $dsn = 'mysql:dbname=school_data;host=localhost';
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
        
        #get the existing tables.
        $sql = "SHOW tables";
        
        $stmt = $db->prepare($sql);
        
        $stmt->execute(); 
        
        #create a new View
        $view = new \view\school_data($this->_action, $stmt->fetchAll(\PDO::FETCH_ASSOC));
        
    }
    
    public function importAction() {
        
        $db = $this->getDB(); 
        
        #Import the csv file data.
            #directory
        $dir = 'data/final/';
        
        #extension
        $ext = '.csv';
        
  
        #field name directory
        $varlistData = array('hd2011.varlist', 'effy2011.varlist', 'f1011_f1a.varlist'); 
        
        #school data files
        $schoolData = array('hd2011');
        
        #financial information files
        $financialData = array('f1011_f1a', 'f0910_f1a');
        
        #enrollment data
        $enrollmentData = array('effy2010', 'effy2011');
        

        /*
         *import the varllist data which will be used to create the
         *data tables
         */
        
        #create table sql.
        $sql = "DROP TABLE IF EXISTS varlist_data;
                CREATE TABLE varlist_data (
                    varnumber   int not null,
                    varname     char(10) null,
                    datatype    char(1) null,
                    fieldwidth  int null,
                    format      char(10),
                    imputationvar   char(10),
                    vartitle    char(200),
                    
                    PRIMARY KEY (varnumber)
                );";
                
        #build the statement. 
        $stmt = $db->prepare($sql);
        
        #execute the statement 
        $stmt->execute(); 
        
        #import the varlist data
        foreach($varlistData as $file) {
            //$this->import('varlist_data', $file);
            #build the filepath
            $filepath = $dir . $file . $ext; 
            $this->import('varlist_data', $csv = new \library\csvfile($filepath, true), true);
             
        }
       
       
        /*
         *build the tables for the school data and import.
         */
        $first = array_shift($schoolData);
        
        
        
        /*
         *build the table for the financial data and import.
         */
        
        
        /*
         *build the table for enrollment data and import.
         */
             
             
        //header("Location:./?page=school_data");
        exit; 
    }
    
    private function import($tablename, $csv, $ignore = false) {
        
        $db = $this->getDB();
        /*
        #directory
        $dir = 'data/final/';
        
        #extension
        $ext = '.csv';
        
        #build the filepath
        $filepath = $dir . $filename . $ext; 
        
        #create a csv object
        try{    
            $csv = new \library\csvfile($filepath, true);
        } catch(\Exception $e) {
            echo("here"); 
            var_dump($e->getMessage()); 
        }
        */
        #get the csv headings.   
        $fields = $csv->getHeadings(); 
        
        
        /*
         *loop and build a sql insert query.
         */
        $sql = "INSERT ";
        
        #if ignore flag is set, add the appropriate directive. 
        if($ignore) {
            $sql .= ' IGNORE ';
        }
        
        $sql .= "INTO " . $tablename . '(';
        
        foreach($fields as $field) {
            //$sql .= $field['Field'] . ',';
            $sql .= '`' . $field . '`,'; 
        }
        
        #trim off the last ,
        $sql = rtrim($sql, ',');
        
        $sql .= ") VALUES ";
        
        #get the data from the csv object.
        $data = $csv->getData();
        
        #get the data count. 
        $len = count($data);
        $count = 0; 
        
        
        foreach($data as $row) {
            $values = '(';
            
            foreach($row as $field) {
                //$values .= "'" . $field . "',";
                $values .= $db->quote($field) . ','; 
            }
            $values = rtrim($values, ','); 
            $values .= ')';
            
            $sql .= $values;
            
            #increment count
            $count++;
            
            #if the count is less then the length, concatenate a comma. 
            if ($count < $len) {
                $sql .= ','; 
            }
        }
         
        #prepare the sql statement
        $stmt = $db->prepare($sql);
        if($stmt->execute()) {
            return true;
        } else {
            return false; 
        }
        //var_dump($stmt->errorInfo());
    }
    
    private function createTable($fields) {
        
    }
}