var Company_Lead_Quote_Item_Delivery = function()
{
    
}

Company_Lead_Quote_Item_Delivery.prototype.SetAddressOnclickBind = function(element)
{
    element.click(function()
    {
	delivery_id = $("#delivery_id").val();

	location = "/lead-quote-item-delivery/set-address/id/" + delivery_id;
    });
}


