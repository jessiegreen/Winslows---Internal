
var Company_RtoProvider_Application = function() {
    
}

Company_RtoProvider_Application.prototype.ApplicationOnClickBind = function(element)
{
    element.click(function(e)
    {
	button	    = $(e.target);
	location    = "/rto-provider-application/edit/id/0/lead_id/" + 
			button.attr("lead_id") + "/rto_provider_id/" + 
			button.attr("rto_provider_id");
    })
}