<?php
namespace controller;

class school_data extends controller {
    
    private function getDB() {
        
       
        $dsn = 'mysql:dbname=nl79;host=sql.njit.edu';
        $user = 'nl79';
        $password = 'do1z6Qpxa';
        
        $db = null; 
        
        try {
           // $db = new \PDO($dsn, $user, $password, array( PDO::MYSQL_ATTR_LOCAL_INFILE => true));
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
        //$view = new \view\school_data($this->_action, $stmt->fetchAll(\PDO::FETCH_ASSOC));
        $view = new \view\school_data($this->_action, $stmt->fetchAll());
       
    }
   
    
    public function reportAction() {
        
        #get the db connection
        $dbh = $this->getDB(); 
        
        #get the report type
        $type = isset($_REQUEST['type']) && !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
        
        #initialize the sql string
        $sql = ""; 
        
        #switch statement for the report type
        switch($type) {
            case 'enrollment':
                /*
                *Create a web page that shows the colleges that have the highest enrollment.
                */
                #EFYTOTLT - the total enrollment acount. 
                $sql = 'select t1.UNITID, t1.EFYTOTLT as `Total Enrollment`, t1.`YEAR`, t2.INSTNM, t2.ADDR, t2.CITY, t2.STABBR, t2.ZIP 
                        from enrollment_data as t1, institution_data as t2 
                        where t1.UNITID = t2.UNITID 
                        order by t1.EFYTOTLT 
                        desc limit 100'; 
                
                break;
            
            case 'liabilities':
                /*
                *Create a web page that that lists the colleges with the largest amount of total liabilities.
                */
                #F1A13 - total liabilities. 
                $sql = 'select t1.UNITID, t1.F1A13 as `Total Liabilities`, t1.`YEAR`, t2.INSTNM, t2.ADDR, t2.CITY, t2.STABBR, t2.ZIP 
                        from financial_data as t1, institution_data as t2 
                        where t1.UNITID = t2.UNITID 
                        order by t1.F1A13 
                        desc limit 100';
                        
                break;
            
            case 'assets':
                /*
                *Create a web page that lists the colleges with the largest amount of net assets.
                */
                #F1A18 - total net assets
                $sql = 'select t1.UNITID, t1.F1A18 as `Net Assets`, t1.`YEAR`, t2.INSTNM, t2.ADDR, t2.CITY, t2.STABBR, t2.ZIP 
                        from financial_data as t1, institution_data as t2 
                        where t1.UNITID = t2.UNITID 
                        order by t1.F1A18 
                        desc limit 100';
                
                break;
            
            case 'assets_per_student':
                /*
                *Create a web page that lists the colleges with the largest amount of net assets per student.
                */
                #financial_data.F1A18 - total net assets
                #enrollment_data.EFYTOTLT - the total enrollment acount.
                
                /*
                 *SELECT t1.UNITID , (t2.F1A18/t3.EFYTOTLT) AS assets_per_student, t2.`YEAR`, t1.INSTNM, t1.ADDR, t1.CITY, t1.STABBR, t1.ZIP 
                    FROM institution_data AS t1 INNER JOIN financial_data AS t2 ON t1.UNITID = t2.UNITID inner join enrollment_data as t3 on t2.UNITID = t3.UNITID
                    where t3.LSTUDY = 999
                    order by assets_per_student desc
                    limit 100;
                */
                
                /*
                 *
                $sql = 'select t1.UNITID, (t1.F1A18/t3.EFYTOTLT) as `net assets per student`, t1.`YEAR`, t2.INSTNM, t2.ADDR, t2.CITY, t2.STABBR, t2.ZIP 
                        from financial_data as t1, institution_data as t2, enrollment_data as t3
                        where t1.UNITID = t2.UNITID
                        limit 100';
                */
                
                $sql = 'SELECT t1.UNITID ,t2.F1A18 AS "NET ASSETS", t3.EFYTOTLT AS "ENROLLMENT", (t2.F1A18/t3.EFYTOTLT) AS assets_per_student, t2.`YEAR`, t1.INSTNM, t1.ADDR, t1.CITY, t1.STABBR, t1.ZIP 
                        FROM institution_data AS t1 inner JOIN financial_data AS t2 ON t1.UNITID = t2.UNITID inner join enrollment_data as t3 on t2.UNITID = t3.UNITID
                        where t3.LSTUDY = 999 and  t2.`YEAR` = t3.`YEAR`
                        order by assets_per_student desc
                        limit 100'; 
                break;
            
            case 'enrollment_rate':
                /*
                *Create a web page that shows the colleges with the largest percentage increase
                *in enrollment between the years of 2011 and 2010.
                */
                /*
                $sql = 'select t1.UNITID, (((tbl2.EFYTOTLT - tbl1.EFYTOTLT)/ tbl1.EFYTOTLT) * 100) as ratio,t1.INSTNM, t1.ADDR, t1.CITY, t1.STABBR, t1.ZIP
                        FROM institution_data as t1 inner join 
                        (select UNITID, EFYTOTLT from enrollment_data where `YEAR` = 2010 and LSTUDY = 999) as tbl1 on t1.UNITID = tbl1.UNITID 
                        INNER JOIN   
                        (select UNITID, EFYTOTLT from enrollment_data where `YEAR` = 2011 AND LSTUDY = 999) as tbl2 ON tbl1.UNITID = tbl2.UNITID'; 
                */
                
                $sql = 'select t1.UNITID, (((tbl2.EFYTOTLT - tbl1.EFYTOTLT)/ tbl1.EFYTOTLT) * 100) as `Enrollment % Change`,t1.INSTNM, t1.ADDR, t1.CITY, t1.STABBR, t1.ZIP
                        FROM institution_data as t1 inner join 
                        (select UNITID, EFYTOTLT from enrollment_data where `YEAR` = 2010 and LSTUDY = 999) as tbl1 on t1.UNITID = tbl1.UNITID 
                        INNER JOIN   
                        (select UNITID, EFYTOTLT from enrollment_data where `YEAR` = 2011 AND LSTUDY = 999) as tbl2 ON tbl1.UNITID = tbl2.UNITID
                        ORDER BY `Enrollment % Change` desc';
                break;
            
            default:
                
                break; 
        }
         
        #prepare the statement
        $stmt = $dbh->prepare($sql);
        
        #execute the query
        $stmt->execute(); 
        
        $view = new \view\school_data($this->_action, $stmt->fetchAll(\PDO::FETCH_ASSOC)); 

    }
    
    public function fullimportAction() {
        
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
            $csv = new \library\csvfile($filepath, true);
            $this->import('varlist_data',$csv , array('ignore' => true)); 
        }
        
        unset($csv); 
     
        
        /*
         *build the tables for the school data and import.
         */
   
        $file = array_shift($schoolData);
        $filepath = $dir . $file . $ext;
        #additional table field for the data year
        $field = array('fieldname' => 'YEAR',
                       'datatype' => 'int(4)',
                       'null' => 'NULL');
        $csv = new \library\csvfile($filepath, true);
        
        $this->createTable('institution_data',$csv->getHeadings(), array($field));
        
        #import the data into the newly created table.
        #addition field to store the date
        $field = array('fieldname' => 'YEAR',
                       'value' => 2011); 
        $this->import('institution_data', $csv, array('ignore' => true,
                                                      'fields' => array($field)));
       
        unset($csv);
      
        /*
         *build the table for the financial data and import.
         */
     
        #extract the headers. 
        $headers = $this->getHeaders($financialData);
        
        #additional table field for the data year
        $field = array('fieldname' => 'YEAR',
                       'datatype' => 'int(4)',
                       'null' => 'NULL');
        
        $this->createTable('financial_data',$headers, array($field));
        
        #import the data
        $csv = new \library\csvfile($this->buildFilepath(array_shift($financialData)), true);
       
        #import the data into the newly created table.
        #addition field to store the date
        $field = array('fieldname' => 'YEAR',
                       'value' => 2010); 
        $this->import('financial_data', $csv, array('ignore' => true,
                                                      'fields' => array($field)));
        unset($csv);
        
        
        $csv = new \library\csvfile($this->buildFilepath(array_shift($financialData)), true);
       
        #import the data into the newly created table.
        #addition field to store the date
        $field = array('fieldname' => 'YEAR',
                       'value' => 2009); 
        $this->import('financial_data', $csv, array('ignore' => true,
                                                      'fields' => array($field)));
        unset($csv);
         
        /*
         *build the table for enrollment data and import.
         */
        /*
        $headings = $this->getHeaders($enrollmentData);
        
        
        #additional table field for the data year
        $field = array('fieldname' => 'YEAR',
                       'datatype' => 'int(4)',
                       'null' => 'NULL');
       
        $this->createTable('enrollment_data',$headings, array($field));
        */
        
        #import the data.       
        //header("Location:./?page=school_data");
        exit; 
    }
    
     
    private function getHeaders($list) {
        
        if(is_array($list) && !empty($list)) {
            
            $headers = array();
            
            foreach($list as $filename) {
                
                $filepath = $this->buildFilepath($filename);
                
                $file = fopen($filepath, 'r');
                $arr = explode(',' ,fgets($file));
                
                foreach($arr as $field) {
                    $headers[trim($field)] = trim($field); 
                }
                
            }
        }
        
        return $headers; 
    }
    
    private function buildFilepath($filename) {
        #directory
        $dir = 'data/final/';
        
        #extension
        $ext = '.csv';
        
        return $dir . $filename . $ext;
        
    }
    
    private function import($tablename, $csv, $args = array()) {
        
        $db = $this->getDB();
       
        #get the csv headings.   
        $fields = $csv->getHeadings(); 
        
        /*
         *count the number of record in the set,
         *if the number is very high, divide the import
         *queries into multiple sets.
         */
        
        
         #items in a set
        $setCount = 500;
        
        $collection = $csv->getData();
       
        
        $max = count($collection) / $setCount; 
        for($i = 0; $i < $max; $i++) {
            #set the start boundary. 
            $start = $setCount * $i;
            
            #slice off the dataset
            $data = array_slice($collection, $start, $setCount);
            
            #build the sql and execute the query.
            $sql = "INSERT ";
        
            #if ignore flag is set, add the appropriate directive. 
            if(isset($args['ignore'])) {
                $sql .= ' IGNORE ';
            }
            
            $sql .= "INTO " . $tablename . '(';
            
            #setup the field names for the insert query. 
            foreach($fields as $field) {
                //$sql .= $field['Field'] . ',';
                $sql .= '`' . trim($field) . '`,'; 
            }
            
            #check if any additional fields were supplied
            if(isset($args['fields'])) {
                foreach($args['fields'] as $field) {
                    $sql .=  '`' . $field['fieldname'] . '`,'; 
                }
            }
            #trim off the last ,
            $sql = rtrim($sql, ',');
            
            $sql .= ") VALUES ";

            #get the data count. 
            $len = count($data);
            $count = 0; 
            
            
            foreach($data as $row) {
                $values = '(';
                
                foreach($row as $field) {
                    //$values .= "'" . $field . "',";
                    $values .= $db->quote($field) . ',';
                }
                
                #check if any additional fields were supplied
                if(isset($args['fields'])) {
                    foreach($args['fields'] as $field) {
                        $values .= $field['value'] . ','; 
                    }
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
            #execute
            $result = $stmt->execute();

        }

    }
    
    private function createTable($tablename, $headings, $fields = array()) {
        $db = $this->getDB();
        
        #get the varname data from the database.
        $sql = "SELECT * FROM varlist_data";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        /*
         *build an asscciative array using the varname as key.
         */
        $hash = array();
        
        if(is_array($result) && !empty($result)) {
            foreach($result as $field) {
                $hash[strtolower($field['varname'])] = $field; 
            }
        }
        
        #build the table creation query
        $sql = 'DROP TABLE IF EXISTS ' . $tablename . '; ';
        $sql .= 'CREATE TABLE ' . $tablename . '( ';
        
        
        foreach($headings as $field) {
            
            if(isset($hash[$field])) {
                $properties = $hash[$field];
                #field name
                
                $sql .= $properties['varname'] . ' ';
                
                #type
                switch($properties['datatype']) {
                    case 'N':
                        $sql .= ' int(' . $properties['fieldwidth'] . ') '; 
                        break;
                    
                    case 'A':
                    
                        $sql .= is_numeric($properties['fieldwidth']) &&
                            $properties['fieldwidth'] <= 255 ? ' char(' . $properties['fieldwidth'] . ') ' : ' text' ; 
                        break;
                    
                    default:
                        break; 
                }
                
                #allows null
                $sql .= ' NULL';
                
                $sql .= ','; 
            } else {
                 
                $sql .= $field . ' varchar(10) NULL,'; 
            }
        }
        
        #add any additional custom fields.
        if(is_array($fields) && !empty($fields)) {
            foreach($fields as $field) {
                $sql .= implode(' ', $field) . ','; 
            }
        }
        
        #trim off the trailing comma
        $sql = rtrim($sql, ','); 
        //$sql .= ' PRIMARY KEY (UNITID)'; 
        
        $sql .= ' ); ';
       
        #prepare the statement
        $stmt = $db->prepare($sql);
        if($stmt->execute()) {
            return true;
        } else {

            return false;
        }
        
    }
}
