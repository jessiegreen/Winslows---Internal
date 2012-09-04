var Website_Resource_ManageRoles = function(){
    
}

Website_Resource_ManageRoles.prototype.AddOnclickBind = function(element)
{
    element.click(function(e){
	button	    = $(e.target);
	role_id	    = $("#add_role_id").val();
	resource_id = $("#resource_id").val();
	if(role_id == "undefined" || role_id.length > 0)
	    location    ='/website/resource/add-role/role_id/' + role_id + '/resource_id/' + resource_id;
	else alert("Please choose a role to add");
    });
}

Website_Resource_ManageRoles.prototype.RemoveOnclickBind = function(element)
{
    element.click(function(e){
	button	    = $(e.target);
	role_id	    = button.parent().attr("role_id");
	resource_id = $("#resource_id").val();
	location    ='/website/resource/remove-role/role_id/' + role_id + '/resource_id/' + resource_id;
    });
}


