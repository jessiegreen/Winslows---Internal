function Location() {
    
}

Location.prototype.SetAddressOnclickBind = function(element){
    element.click(function(){
	location_id  = $("#location_id").val()
	location    ='/locationaddress/edit/id/0/location_id/'+location_id;
    });
}

Location.prototype.SetPhoneOnclickBind = function(element){
    element.click(function(){
	location_id  = $("#location_id").val()
	location    ='/locationphonenumber/edit/id/0/location_id/'+location_id;
    });
}


