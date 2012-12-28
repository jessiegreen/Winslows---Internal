function Company_Employee_Account()
{
    
}

Company_Employee_Account.prototype.ManageRolesOnclickBind = function(element)
{
    element.click(function()
    {
	location = "/employee-account/manage-roles/id/" + $("#account_id").val();
    });
}


