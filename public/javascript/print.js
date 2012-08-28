var Print = function()
{
    
}

Print.prototype.renderToModel()
{
    $.colorbox({
	href:"/document/create/quote/id/" + $("quote_id")
    });
}


