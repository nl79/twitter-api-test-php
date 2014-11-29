<?php
namespace view;


class federal_employees extends view {
    
    public function indexView($data) {
        #build the html table
        $this->_output .= \library\html::table(array('data' => $data), true);
        
         
    }
    
}