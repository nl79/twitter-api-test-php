<?php
namespace view;


class school_data extends view {
    
    public function indexView($data) {
         
        $html = "<div class='div-school-data-content-wrapper'>"; 
        
        
        #if the data is empty display the import button
        if(empty($data)) {
            $html .= "<h3>Tables Do Not Exist<h3>";
            $html .= "<a href='./?page=school_data&ac=import'>Import Data</a>";
            
            
        } else {
            
            
            /*
            
            #build a UL for the existing tables.
            $html .= "<ul class='ul-table-list'>";
            foreach($data as $key => $value) {
                $html .= "<li>" . $value[0] . "</li>"; 
            }
            $html .= "</ul>";
            */
            #build the links to the specific reports.
            $html .= $this->mainNav();
            
            #build the data container
            $html .= "<div id='div-content' class='div-school-data-content'></div>"; 
            
            
        }
        
        $html .= "</div>";
        
        #build the html table
        $this->_output .= $html;  
        
    }
    
    public function reportView($data) {
        
        /*
         *if data is an array and is not empty, build a table.
         */
        if(is_array($data) && !empty($data)) {
            $html = \library\html::table(array('id'=>'table-school-data-report',
                                           'border' => '1',
                                           'data' => $data), true, false);
        }
        
        $this->_output .= $html; 
    }
    
    private function mainNav() {
        $links = array('enrollment',
                       'liabilities',
                       'assets',
                       'assets_per_student',
                       'enrollment_rate'); 
        
        $html = "<div class='div-school-data-nav-main'>
                <ul id='ul-links' class='ul-school-data-nav-main'>";
        
            foreach($links as $link) {
                $html .= "<li class='school-data-nav-link'>"; 
                $html .= "<a target='div-content'
                            href='./?page=school_data&ac=report&type=" . strtolower($link) . "'>"; 
                $html .= str_replace('_', ' ', $link) .
                '</a></li>'; 
            }
            
        $html .= "</ul><div class='div-clear-both'></div></div>";
        
        return $html; 
    }
}