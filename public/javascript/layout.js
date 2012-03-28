/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var layout = function (){
//    this.menu_array  = "";
    
}

/*
 * Initialize the suckerfish nav menu
 * 
 * @param element_id
 */
layout.prototype.nav_menu = function (){
    $(document).ready(function(){
	$("ul.sf-menu").superfish({ 
            delay:       300,                            // one second delay on mouseout 
            animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation 
            speed:       'fast'});
    });
}




