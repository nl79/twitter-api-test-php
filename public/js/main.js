$ = function(id) {
    return document.getElementById(id); 
}

function disable(elements) {
    
    if (elements.length && elements.length > 0) {
        
        for (var i = 0; i < elements.length; i++) {
            console.log(elements[i]); 
            elements[i].setAttribute('disabled', 'disabled'); 
        }
    }
    console.log(elements.length); 
}



function select(evt) {
    
    //prevent the default click action. 
    evt.preventDefault();
    
    /*
     *set a waiting message
     */
    document.getElementById("div-content").innerHTML = "<h1>Please Wait - We're Working on Your Request(It may take a while, so you should probably go get some coffee and make a sandwich)"; 
    
    
    //get the target url
    var url = evt.target;
    
    //build an ajax call.
    var ajax = new XMLHttpRequest();
    
    ajax.onreadystatechange=function() {
        
    if (ajax.readyState==4 && ajax.status==200)
      {
      document.getElementById("div-content").innerHTML=ajax.responseText;
      }
    }
    
    /*
     *disable the links to prevent clicking before the request is over.
     */
    disable(document.getElementsByClassName('a-link')); 
    
    
    
    ajax.open("GET",url + '&ajax=ajax' ,true);
    ajax.send();
    
}

function init() {
    $('ul-links').setAttribute("onclick", 'select(event)');    
}



window.onload = function() {
    init(); 
}