function Customer() {
    
}

Customer.prototype.AddAddressClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/personaddress/edit/id/0/person_id/" + $("#customer_id").val();
    });
}

Customer.prototype.AddPhoneClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/personphonenumber/edit/id/0/person_id/" + $("#customer_id").val();
    });
}

Customer.prototype.AddEmailClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/personemailaddress/edit/id/0/person_id/" + $("#customer_id").val();
    });
}

Customer.prototype.AddContactClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/contact/edit/id/0/lead_id/" + $("#customer_id").val();
    });
}



