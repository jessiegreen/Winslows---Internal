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

Item.prototype.DeliverySetOnclickBind = function(element)
{
    element.click(function()
    {
	item_id = $("#item_id").val();

	location = "/lead-quote-item/set-delivery-type/id/" + item_id;
    });
}


