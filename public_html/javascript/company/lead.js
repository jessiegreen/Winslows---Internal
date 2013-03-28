function Lead() {
    
}

Lead.prototype.AddAddressClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/lead-address/edit/id/0/person_id/" + $("#lead_id").val();
    });
}

Lead.prototype.AddPhoneClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/lead-phone-number/edit/id/0/person_id/" + $("#lead_id").val();
    });
}

Lead.prototype.AddEmailClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/lead-email-address/edit/id/0/person_id/" + $("#lead_id").val();
    });
}

Lead.prototype.AddContactClickBind = function(element_id){
    $("#"+element_id).click(function(){	
	location = "/lead-contact/edit/id/0/lead_id/" + $("#lead_id").val();
    });
}

Lead.prototype.AddQuoteClickBind = function(element_id){
    $("#"+element_id).click(function(){	
	location = "/lead-quote/edit/id/0/lead_id/" + $("#lead_id").val();
    });
}



