function Navigation() {
    
}

Navigation.prototype.AddOnclickBind = function(element){
    element.click(function(){
	location='/maintenance/navigationedit';
    });
}

Navigation.prototype.EditOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/maintenance/navigationedit/id/' + button.parent().attr("menuitem_id");
    });
}

Navigation.prototype.AddChildOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/maintenance/navigationedit/parent_id/' + button.parent().attr("menuitem_id");
    });
}

Navigation.prototype.RemoveOnclickBind = function(element){
    element.click(function(e){
	if(confirm("Are you sure you want to delete this menu item?")){
	    button = $(e.target);
	    menu_id = $("#menu_id").val();
	    location='/maintenance/navigationremove/menu_id/'+menu_id+
			'/menuitem_id/' + button.parent().attr("menuitem_id");
	}
    });
}

