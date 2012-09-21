function Option()
{
    
}

Option.prototype.ManageOptionsOnclickBind = function(element)
{
    element.click(function()
    {
	option_id  = $("#option_id").val()
	location    ='/supplier-product-configurable-option/manageoptions/id/'+option_id;
    });
}

Option.prototype.OptionAddOnclickBind = function(element)
{
    element.click(function()
    {
	option_id  = $("#option_id").val()
	location    ='/supplier-product-configurable-option-parameter/edit/id/0/option_id/'+option_id;
    });
}

Option.prototype.EditOnclickBind = function(element)
{
    element.click(function(e)
    {
	button = $(e.target);
	location='/supplier-product-configurable-option/edit/id/' + button.parent().attr("option_id");
    });
}

Option.prototype.AddOnclickBind = function(element)
{
    element.click(function()
    {
	location    ='/supplier-product-configurable-option/edit/id/0';
    });
}

Option.prototype.ViewOnclickBind = function(element)
{
    element.click(function(e){
	button = $(e.target);
	location='/supplier-product-configurable-option/view/id/' + button.parent().attr("option_id");
    });
}

Option.prototype.DeleteOnclickBind = function(element)
{
    element.click(function(e)
    {
	button = $(e.target);
	
	if(confirm("Stop!! Are you sure you want to delete this option? IT WILL DELETE ALL PARAMETERS AND VALUES ATTACHED TO IT! This can not be undone!!"))
	{
	    location='/supplier-product-configurable-option/delete/id/' + button.parent().attr("option_id");
	}
    });
}