function Company_RtoProvider_Program_Fee_Range()
{
    
}

Company_RtoProvider_Program_Fee_Range.prototype.EditOnclickBind = function(element)
{
    element.click(function(e)
    {
	button = $(e.target);
	location='/rto-provider/view/id/' + button.parent().attr("rto_provider_id");
    });
}

Company_RtoProvider_Program_Fee_Range.prototype.AddOnclickBind = function(element)
{
    element.click(function()
    {
	location    ='/rto-provider/edit/id/0';
    });
}

Company_RtoProvider_Program_Fee_Range.prototype.ManageProductsOnclickBind = function(element)
{
    element.click(function()
    {
	program_id  = $("#program_id").val()
	location    = '/rto-provider-program/manage-products/id/' + program_id;
    });
}

Company_RtoProvider_Program_Fee_Range.prototype.AddPercentageFeeOnclickBind = function(element)
{
    element.click(function()
    {
	program_id  = $("#program_id").val()
	location    = '/rto-provider-program-fee-percentage/edit/id/0/program_id/' + program_id;
    });
}

Company_RtoProvider_Program_Fee_Range.prototype.AddRangeFeeOnclickBind = function(element)
{
    element.click(function()
    {
	program_id  = $("#program_id").val()
	location    = '/rto-provider-program-fee-range/edit/id/0/program_id/' + program_id;
    });
}
