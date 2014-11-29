<?php
namespace view;

class twitter extends view {
    
    /*
     *@method indexView() - default content for the index route
     */
    public function indexView($data = array()) {
        $this->_output .= "
        <div id='div-twitter-toolbar'>
			
                <form id='form-tweet' class='align-vertical' method='post' action='http://web.njit.edu/~nl79/is218/is218proj3/'>
                        <input type='hidden' name='page' value='twitter' />
                        
                        <label id='label-tweet' for='textarea-status'>Message:</label>
                        <textarea id='textarea-status' name='status' maxlength='130'></textarea>
                        <button id='button-tweet' type='submit' name='ac' value='tweet' >Tweet</button>
                </form>
                
                <ul id='ul-links'>
                        <li><a href='./?page=twitter&ac=profile'>View Profile</a></li>
                        <li><a href='./?page=twitter&ac=tweets'>View My Tweets</a></li>
                        <li><a href='./?page=twitter&ac=timeline'>View Timeline</a></li>
                        <li><a href='./?page=twitter&ac=followers'>View Followers</a></li>
                        
                </ul>
        </div>
	<div id='div-content'></div>
        
        "; 

    }
    
    
    public function tweetView ($data = array()) {
       
        if(!is_null($data) && is_array($data) && !empty($data)) {
            $this->_output .= '<table border=\'1\'><thead><tr><th>Key</th><th>Value</th></tr></thead>'; 
            foreach($data as $key => $value) {
                if(!is_scalar($value)) { continue; }
                
                $this->_output .= '<tr><td>' . $key . '</td><td>' . $value . '</td></tr>'; 
            }
            
            $this->_output .= '</table><tfoot><tr><th><th></tr></tfoot>';
            
        } else {
            $this->_output .= "<h3>Invalid Message Supplied</h3>"; 
        }
    }
    
    public function profileView ($data = array()) {

        if(!is_null($data) && is_array($data) && !empty($data)) {
            $this->_output .= '<table border=\'1\'><thead><tr><th>Key</th><th>Value</th></tr></thead>'; 
            foreach($data as $key => $value) {
                if(!is_scalar($value)) { continue; }
                
                $this->_output .= '<tr><td>' . $key . '</td><td>' . $value . '</td></tr>'; 
            }
            
            $this->_output .= '</table><tfoot><tr><th><th></tr></tfoot>';
            
        }
        
    }
    
    public function tweetsView ($data = array()) {
       
        if(!is_null($data) && is_array($data) && !empty($data)) {
            $this->_output .= \library\html::table(array('id'=>'table-tweets',
                                           'border' => '1',
                                           'data' => $data), true, false);
        }
    }
    
    public function followersView ($data = array()) { 
        
        if(!is_null($data) && is_array($data) && !empty($data) && isset($data['users'])) {
            $this->_output .= \library\html::table(array('id'=>'table-followers',
                                           'border' => '1',
                                           'data' => $data['users']), true, false);
        }
        
    }
    
    public function timelineView ($data = array()) {
         if(!is_null($data) && is_array($data) && !empty($data)) {
            $this->_output .= \library\html::table(array('id'=>'table-timeline',
                                           'border' => '1',
                                           'data' => $data), true, false);
        }
    }  
}