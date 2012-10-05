function Quote() {
    
}

Quote.prototype.ViewItemOnClickBind = function(element)
{
    element.click(function(e)
    {
	button = $(e.target);
	
	location = "/lead-quote-item/view/id/"+button.attr("item_id");
    })
}

Quote.prototype.AddItemOnClickBind = function(element)
{
    element.click(function()
    {	
	location = "/lead-quote-item/edit/id/0/quote_id/"+$("#quote_id").val();
    })
}

Quote.prototype.AddInventoryItemOnClickBind = function(element)
{
    element.click(function()
    {	
	location = "/lead-quote/add-inventory-item/id/"+$("#quote_id").val();
    })
}

Quote.prototype.PrintOnClickBind = function(element)
{
    element.click(function(e)
    {
	console.log("Print")
    })
}

Quote.prototype.SellOnClickBind = function(element)
{
    element.click(function(e)
    {
	location = "/lead-quote/sell/id/" + $("#quote_id").val();
    })
}

Quote.prototype.ApplicationOnClickBind = function(element)
{
    element.click(function(e)
    {
	button	    = $(e.target);
	location    = "/rto-provider-application/edit/id/0/lead_id/" + 
			button.attr("lead_id") + "/rto_provider_id/" + 
			button.attr("rto_provider_id");
    })
}

Quote.prototype.ViewItemOnClickBind = function(element)
{
    element.click(function(e)
    {
	button	    = $(e.target);
	location    = "/lead-quote-item/edit/id/" + 
			button.attr("item_id");
    })
}