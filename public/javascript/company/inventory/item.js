var Company_Inventory_Item = function(){
    
}

Company_Inventory_Item.prototype.ProductManualOnclickBind = function(element, instance_id)
{
    element.click(function()
    {
	location = "/supplier-product-configurable-instance/manual/id/" + instance_id
    });
}

Company_Inventory_Item.prototype.ProductBuilderOnclickBind = function(element, instance_id)
{
    element.click(function()
    {
	location = "/builder?type=carport";
    });
}

Company_Inventory_Item.prototype.ImageAddOnclickBind = function(element, instance_id)
{
    element.click(function()
    {
	location    = '/supplier-product-instance-file-image/edit/id/0/instance_id/' + instance_id;
    });
}


