function Resource() {
    
}

Resource.prototype.EditOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/maintenance/resourceedit/id/' + button.parent().attr("resource_id");
    });
}

Resource.prototype.AddOnclickBind = function(element){
    element.click(function(e){
	button	    = $(e.target);
	role_id	    = $("#add_role_id").val();
	resource_id = $("#resource_id").val();
	if(role_id == "undefined" || role_id.length > 0)
	    location    ='/maintenance/addrole/role_id/' + role_id + '/resource_id/' + resource_id;
	else alert("Please choose a role to add");
    });
}

Resource.prototype.RemoveOnclickBind = function(element){
    element.click(function(e){
	button	    = $(e.target);
	role_id	    = button.parent().attr("role_id");
	resource_id = $("#resource_id").val();
	location    ='/maintenance/removerole/role_id/' + role_id + '/resource_id/' + resource_id;
    });
}

