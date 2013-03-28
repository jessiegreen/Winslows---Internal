function Company_Dealer_Location()
{
    
}

Company_Dealer_Location.prototype.SetAddressOnclickBind = function(element)
{
    element.click(function()
    {
	location_id  = $("#location_id").val()
	location     ='/dealer-location-address/edit/id/0/location_id/'+location_id;
    });
}

Company_Dealer_Location.prototype.SetPhoneOnclickBind = function(element)
{
    element.click(function()
    {
	location_id  = $("#location_id").val()
	location    ='/dealer-location-phone-number/edit/id/0/location_id/'+location_id;
    });
}


