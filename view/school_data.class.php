<?php
namespace view;


class school_data extends view {
    
    public function indexView($data) {
        
        
        $html = "<a href='./?page=school_data&ac=import'>Import Data</a>";
        
        #if the data is empty display the import button
        if(empty($data)) {
            $html .= "<h3>Tables Do Not Exist<h3>"; 
            
            
        } else {
            
            #build a UL for the existing tables.
            $html .= "<ul class='ul-table-list'>";
            foreach($data[0] as $key => $value) {
                $html .= "<li>" . $value . "</li>"; 
            }
            $html .= "</ul>";
            
        }
        
        
        #build the html table
        $this->_output .= $html;  
        
         
    }
    
}