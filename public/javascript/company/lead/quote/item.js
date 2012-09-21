var Item = function(){
    
}

Item.prototype.ProductManualOnclickBind = function(element, instance_id)
{
    element.click(function()
    {
	location = "/supplier-product-configurable-instance/manual/id/" + instance_id
    });
}

Item.prototype.ProductBuilderOnclickBind = function(element, instance_id)
{
    element.click(function()
    {
	location = "/builder?type=carport";
    });
}


