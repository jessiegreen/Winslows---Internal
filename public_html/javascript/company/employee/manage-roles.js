function Company_Employee_Role() {
    
}


Company_Employee_Role.prototype.FormSubmit = function()
{
    $("form").submit(function()
    {
	role_id		= $("#company_employee_manage_roles-role_id").val();
	employee_id	= $("#employee_id").val();
	
	if(role_id != "undefined" && role_id.length > 0)
	    location    ='/employee/add-role/role_id/' + role_id + '/id/' + employee_id;
	else alert("Please choose a role to add");
	return false;
    });
}

Company_Employee_Role.prototype.RemoveRoleOnclickBind = function(element)
{
    element.click(function(e)
    {
	button		= $(e.target);
	role_id		= button.parent().attr("role_id");
	employee_id	= $("#employee_id").val();
	location	='/employee/remove-role/role_id/' + role_id + '/id/' + employee_id;
    });
}


