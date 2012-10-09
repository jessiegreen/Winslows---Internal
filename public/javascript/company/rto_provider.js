function RtoProvider()
{
    
}

RtoProvider.prototype.EditOnclickBind = function(element)
{
    element.click(function(e)
    {
	button = $(e.target);
	location='/rto-provider/view/id/' + button.parent().attr("rto_provider_id");
    });
}

RtoProvider.prototype.AddOnclickBind = function(element)
{
    element.click(function()
    {
	location    ='/rto-provider/edit/id/0';
    });
}

RtoProvider.prototype.AddProgramOnclickBind = function(element)
{
    element.click(function()
    {
	rto_provider_id	    = $("#rto_provider_id").val()
	location	    = '/rto-provider-program/edit/id/0/rto_provider_id/' + rto_provider_id;
    });
}



RtoProvider.prototype.AddPercentageFeeOnclickBind = function(element)
{
    element.click(function()
    {
	rto_provider_id	= $("#rto_provider_id").val()
	location	= '/rto-provider-fee-percentage/edit/id/0/rto_provider_id/' + rto_provider_id;
    });
}

RtoProvider.prototype.AddRangeFeeOnclickBind = function(element)
{
    element.click(function()
    {
	rto_provider_id	= $("#rto_provider_id").val()
	location	= '/rto-provider-fee-range/edit/id/0/rto_provider_id/' + rto_provider_id;
    });
}
