function Value() {
    
}

Value.prototype.EditOnclickBind = function(element)
{
    element.click(function(e)
    {
	button	 = $(e.target);
	location = '/company/supplier-product-configurable-option-parameter-value/edit/id/' + 
		    button.parent().attr("value_id");
    });
}

Value.prototype.DeleteOnclickBind = function(element)
{
    element.click(function(e)
    {
	button = $(e.target);
	
	if(confirm("Are you sure you want to delete this value? This can not be undone!"))
	{
	    location = '/company/supplier-product-configurable-option-parameter-value/delete/id/' + 
			button.parent().attr("value_id");
	}
    });
}

Value.prototype.AddOnclickBind = function(element)
{
    element.click(function()
    {
	location = '/company/supplier-product-configurable-option-parameter-value/edit/id/0';
    });
}