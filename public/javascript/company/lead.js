function Lead() {
    
}

Lead.prototype.AddAddressClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/person/address/edit/id/0/person_id/" + $("#lead_id").val();
    });
}

Lead.prototype.AddPhoneClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/person/phone-number/edit/id/0/person_id/" + $("#lead_id").val();
    });
}

Lead.prototype.AddEmailClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/person/email-address/edit/id/0/person_id/" + $("#lead_id").val();
    });
}

Lead.prototype.AddContactClickBind = function(element_id){
    $("#"+element_id).click(function(){	
	location = "/company/lead-contact/edit/id/0/lead_id/" + $("#lead_id").val();
    });
}

Lead.prototype.AddQuoteClickBind = function(element_id){
    $("#"+element_id).click(function(){	
	location = "/company/lead-quote/edit/id/0/lead_id/" + $("#lead_id").val();
    });
}



