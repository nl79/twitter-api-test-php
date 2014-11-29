<?php
namespace controller; 
/*
 *twitter controller class.
 */

class twitter extends controller {
    
    
    /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
    private $_settings = array(
        'oauth_access_token' => "2843175376-aPRNxijTf2fley9GRmd7jl5d4Rs2e38PImJNEcb",
        'oauth_access_token_secret' => "9yu9rim1VfWg0re8yI2SmF3mOJhrHGNguhn7r8mLyf3x2",
        'consumer_key' => "Q62cPZLXNFBZ0kF0UuGRy8T1s",
        'consumer_secret' => "gidZTOAjCWmZwgQgfFUnrkNMddS068148Q4cXerAmbIN4hd3aU"
    );
    
    protected function indexAction () {
         
        $view = new \view\twitter($this->_action, array());
    }
      
    protected function tweetsAction() {
        
        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $requestMethod = 'GET';
        $getfield = '?screen_name=pamosn&trim_user=false&exclude_replies=true&contributor_details=false&include_rts=false';
        
        $twitter = new \library\TwitterAPIExchange($this->_settings);
       
        $result = json_decode($twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest(true), true);
        
        $view = new \view\twitter($this->_action, $result); 
        
    }
    
    protected function profileAction() {
        
        $url = 'https://api.twitter.com/1.1/users/show.json';
        $requestMethod = 'GET';
        $getfield = '?screen_name=pamosn';
        
        $twitter = new \library\TwitterAPIExchange($this->_settings);
        
        $result = $twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest();
        
        $result = json_decode($twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest(true), true); 
        
        $view = new \view\twitter($this->_action, $result);  
    }
    
    protected function tweetAction() {
          
        #extract the status from the request array.
        $status = isset($_REQUEST['status']) && is_string($_REQUEST['status']) &&
                    !empty($_REQUEST['status']) ? $_REQUEST['status'] : null; 
         
        $result = array(); 
         
        if(!is_null($status)) {
        $url = 'https://api.twitter.com/1.1/statuses/update.json';
        $requestMethod = 'POST';
        
        $postfields = array('status'=> $status); 
        
        $twitter = new \library\TwitterAPIExchange($this->_settings);
       
        $result = json_decode($twitter->setPostfields($postfields)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest(true), true); 
        
        }
       
        $view = new \view\twitter($this->_action, $result);
    }
    
    protected function timelineAction() {
        
        $url = 'https://api.twitter.com/1.1/statuses/home_timeline.json';
        $requestMethod = 'GET';
        $getfield = '?screen_name=pamosn&trim_user=true&exclude_replies=true&contributor_details=false&include_entities=false';
        
        $twitter = new \library\TwitterAPIExchange($this->_settings);
       
        $result = json_decode($twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest(true), true); 
        
        $view = new \view\twitter($this->_action, $result);
    }
    
    protected function followersAction() {
        
        $url = 'https://api.twitter.com/1.1/followers/list.json';
        $requestMethod = 'GET';
        $getfield = '?screen_name=pamosn&include_user_entities=false&skip_status=true';
        
        $twitter = new \library\TwitterAPIExchange($this->_settings);
       
        $result = json_decode($twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest(true), true);
        
        $view = new \view\twitter($this->_action, $result); 
    }
    
    protected function followersidsAction() {
        
        /** Perform a GET request and echo the response **/
        /** Note: Set the GET field BEFORE calling buildOauth(); **/
        $url = 'https://api.twitter.com/1.1/followers/ids.json';
        $getfield = '?screen_name=J7mbo';
        $requestMethod = 'GET';
        $twitter = new TwitterAPIExchange($settings);
         $result = json_decode($twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest(true), true);
        
        $view = new \view\twitter($this->_action, $result); 
    }
}
