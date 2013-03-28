function Parameter() {
    
}

Parameter.prototype.ValueAddOnclickBind = function(element)
{
    element.click(function()
    {
	parameter_id	= $("#parameter_id").val()
	location	='/supplier-product-configurable-option-parameter-value/edit/id/0/parameter_id/'+parameter_id;
    });
}

Parameter.prototype.EditOnclickBind = function(element)
{
    element.click(function(e)
    {
	button = $(e.target);
	location='/supplier-product-configurable-option-parameter/edit/id/' + button.parent().attr("parameter_id");
    });
}

Parameter.prototype.AddOnclickBind = function(element)
{
    element.click(function()
    {
	location    ='/supplier-product-configurable-option-parameter/edit/id/0';
    });
}

Parameter.prototype.ViewOnclickBind = function(element)
{
    element.click(function(e)
    {
	button = $(e.target);
	location='/supplier-product-configurable-option-parameter/view/id/' + button.parent().attr("parameter_id");
    });
}

Parameter.prototype.DeleteOnclickBind = function(element)
{
    element.click(function(e)
    {
	button = $(e.target);
	if(confirm("Are you sure? This will delete the parameter and ALL of its values!!!!")){
	    location='/supplier-product-configurable-option-parameter/delete/id/' + button.parent().attr("parameter_id");
	}
    });
}