function Company()
{
    
}

Company.prototype.EditOnclickBind = function(element)
{
    element.click(function(e)
    {
	button = $(e.target);
	location='/index/view/id/' + button.parent().attr("company_id");
    });
}

Company.prototype.AddOnclickBind = function(element)
{
    element.click(function()
    {
	location    ='/index/edit/id/0';
    });
}

Company.prototype.AddLocationOnclickBind = function(element)
{
    element.click(function()
    {
	company_id  = $("#company_id").val()
	location    ='/location/edit/id/0/company_id/' + company_id;
    });
}

Company.prototype.AddEmployeeOnclickBind = function(element)
{
    element.click(function()
    {
	company_id  = $("#company_id").val()
	location    ='/employee/edit/id/0/company_id/' + company_id;
    });
}

Company.prototype.AddWebsiteOnclickBind = function(element)
{
    element.click(function()
    {
	company_id  = $("#company_id").val()
	location    ='/website/edit/id/0/company_id/' + company_id;
    });
}

Company.prototype.AddRtoProviderOnclickBind = function(element)
{
    element.click(function()
    {
	company_id  = $("#company_id").val()
	location    ='/rto-provider/edit/id/0/company_id/' + company_id;
    });
}

Company.prototype.AddDealerOnclickBind = function(element)
{
    element.click(function()
    {
	company_id  = $("#company_id").val()
	location    ='/dealer/edit/id/0/company_id/' + company_id;
    });
}

