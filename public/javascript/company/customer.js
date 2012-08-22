function Customer() {
    
}

Customer.prototype.AddAddressClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/person/address/edit/id/0/person_id/" + $("#customer_id").val();
    });
}

Customer.prototype.AddPhoneClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/person/phone-number/edit/id/0/person_id/" + $("#customer_id").val();
    });
}

Customer.prototype.AddEmailClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/person/email-address/edit/id/0/person_id/" + $("#customer_id").val();
    });
}

Customer.prototype.AddContactClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/company/lead-contact/edit/id/0/lead_id/" + $("#customer_id").val();
    });
}



