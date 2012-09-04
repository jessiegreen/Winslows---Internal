function Navigation() {
    
}

Navigation.prototype.AddOnclickBind = function(element){
    element.click(function(){
	location='/website/menu-item/edit/id/0';
    });
}

Navigation.prototype.EditOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/website/menu-item/edit/id/' + button.parent().attr("menuitem_id");
    });
}

Navigation.prototype.AddChildOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/website/menu-item/edit/id/0/parent_id/' + button.parent().attr("menuitem_id");
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

