function Company_RtoProvider_Program()
{
    
}

Company_RtoProvider_Program.prototype.EditOnclickBind = function(element)
{
    element.click(function(e)
    {
	button = $(e.target);
	location='/rto-provider/view/id/' + button.parent().attr("rto_provider_id");
    });
}

Company_RtoProvider_Program.prototype.AddOnclickBind = function(element)
{
    element.click(function()
    {
	location    ='/rto-provider/edit/id/0';
    });
}

Company_RtoProvider_Program.prototype.ManageProductsOnclickBind = function(element)
{
    element.click(function()
    {
	program_id  = $("#program_id").val()
	location    = '/rto-provider-program/manage-products/id/' + program_id;
    });
}

Company_RtoProvider_Program.prototype.ManageFeesOnclickBind = function(element)
{
    element.click(function()
    {
	program_id  = $("#program_id").val()
	location    = '/rto-provider-program/manage-fees/id/' + program_id;
    });
}
