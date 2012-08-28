function Quote() {
    
}

Quote.prototype.EditItemOnClickBind = function(element)
{
    element.click(function()
    {
	item_id = element.attr("item_id");
	
	$.colorbox({
	    href:"/company/lead-quote/productadd2/item_id/"+item_id
	});
    })
}

Quote.prototype.ExpandItemOnClickBind = function(element)
{
    element.click(function(e)
    {
	button = $(e.target);
	
	$("#item_details_"+button.attr("item_id")).slideToggle();
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
	location = "/company/lead-quote/payment-type/id/" + $("#quote_id").val();
    })
}