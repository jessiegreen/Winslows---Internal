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

