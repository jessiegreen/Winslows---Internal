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