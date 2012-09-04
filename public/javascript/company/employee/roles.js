function Account_Role() {
    
}


Account_Role.prototype.AddRoleOnclickBind = function(element){
    element.click(function(e){
	button		= $(e.target);
	role_id		= $("#add_role_id").val();
	account_id	= $("#account_id").val();
	if(role_id == "undefined" || role_id.length > 0)
	    location    ='/company/website-account/addrole/role_id/' + role_id + '/id/' + account_id;
	else alert("Please choose a role to add");
    });
}

Account_Role.prototype.RemoveRoleOnclickBind = function(element){
    element.click(function(e){
	button		= $(e.target);
	role_id		= button.parent().attr("role_id");
	account_id	= $("#account_id").val();
	location	='/company/website-account/removerole/role_id/' + role_id + '/id/' + account_id;
    });
}


