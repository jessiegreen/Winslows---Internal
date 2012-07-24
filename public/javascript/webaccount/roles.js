function WebAccount_Role() {
    
}


WebAccount_Role.prototype.AddRoleOnclickBind = function(element){
    element.click(function(e){
	button		= $(e.target);
	role_id		= $("#add_role_id").val();
	webaccount_id	= $("#webaccount_id").val();
	if(role_id == "undefined" || role_id.length > 0)
	    location    ='/webaccount/addrole/role_id/' + role_id + '/id/' + webaccount_id;
	else alert("Please choose a role to add");
    });
}

WebAccount_Role.prototype.RemoveRoleOnclickBind = function(element){
    element.click(function(e){
	button		= $(e.target);
	role_id		= button.parent().attr("role_id");
	webaccount_id	= $("#webaccount_id").val();
	location	='/webaccount/removerole/role_id/' + role_id + '/id/' + webaccount_id;
    });
}


