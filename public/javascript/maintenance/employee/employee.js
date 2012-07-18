function MN_Employee() {
    
}

MN_Employee.prototype.EditOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/maintenance/employeeedit/id/' + button.parent().attr("employee_id");
    });
}

MN_Employee.prototype.EditWebAccountOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/maintenance/editwebaccount/id/' + button.parent().attr("employee_id");
    });
}

MN_Employee.prototype.EditRolesOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/maintenance/editroles/id/' + button.parent().attr("employee_id");
    });
}

MN_Employee.prototype.AddAddressOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/maintenance/addaddress/id/' + button.parent().attr("employee_id");
    });
}

MN_Employee.prototype.AddOnclickBind = function(element){
    element.click(function(){
	location    ='/maintenance/employeeedit/';
    });
}

MN_Employee.prototype.RemoveOnclickBind = function(element){
    element.click(function(e){
	button	    = $(e.target);
	role_id	    = button.parent().attr("role_id");
	employee_id = $("#employee_id").val();
	location    ='/maintenance/removerole/role_id/' + role_id + '/employee_id/' + employee_id;
    });
}

MN_Employee.prototype.AddRoleOnclickBind = function(element){
    element.click(function(e){
	button	    = $(e.target);
	role_id	    = $("#add_role_id").val();
	employee_id = $("#employee_id").val();
	if(role_id == "undefined" || role_id.length > 0)
	    location    ='/maintenance/employeeaddrole/role_id/' + role_id + '/employee_id/' + employee_id;
	else alert("Please choose a role to add");
    });
}

MN_Employee.prototype.RemoveRoleOnclickBind = function(element){
    element.click(function(e){
	button	    = $(e.target);
	role_id	    = button.parent().attr("role_id");
	employee_id = $("#employee_id").val();
	location    ='/maintenance/employeeremoverole/role_id/' + role_id + '/employee_id/' + employee_id;
    });
}

