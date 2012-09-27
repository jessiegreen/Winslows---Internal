function Employee() 
{
    
}

Employee.prototype.EditOnclickBind = function(element)
{
    element.click(function(e)
    {
	button = $(e.target);
	location='/employee/view/id/' + button.parent().attr("employee_id");
    });
}

Employee.prototype.AddOnclickBind = function(element)
{
    element.click(function()
    {
	location    ='/employee/edit/id/0';
    });
}

Employee.prototype.AddAddressClickBind = function(element_id)
{
    $("#"+element_id).click(function()
    {
	location = "/employee-address/edit/id/0/person_id/" + $("#employee_id").val();
    });
}

Employee.prototype.AddPhoneClickBind = function(element_id)
{
    $("#"+element_id).click(function()
    {
	location = "/employee-phone-number/edit/id/0/person_id/" + $("#employee_id").val();
    });
}

Employee.prototype.AddEmailClickBind = function(element_id)
{
    $("#"+element_id).click(function()
    {
	location = "/employee-email-address/edit/id/0/person_id/" + $("#employee_id").val();
    });
}

Employee.prototype.AddAccountClickBind = function(element_id)
{
    $("#"+element_id).click(function()
    {
	location = "/employee-account/edit/id/0/employee_id/" + $("#employee_id").val();
    });
}

Employee.prototype.ManageRolesClickBind = function(element_id)
{
    $("#"+element_id).click(function()
    {
	location = "/employee/manage-roles/id/" + $("#employee_id").val();
    });
}

