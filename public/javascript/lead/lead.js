function Lead() {
    
}

Lead.prototype.AddAddressClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/personaddress/edit/id/0/person_id/" + $("#lead_id").val();
    });
}

Lead.prototype.AddPhoneClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/personphonenumber/edit/id/0/person_id/" + $("#lead_id").val();
    });
}

Lead.prototype.AddEmailClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/personemailaddress/edit/id/0/person_id/" + $("#lead_id").val();
    });
}

Lead.prototype.AddContactClickBind = function(element_id){
    $("#"+element_id).click(function(){	
	location = "/contact/edit/id/0/lead_id/" + $("#lead_id").val();
    });
}

Lead.prototype.AddQuoteClickBind = function(element_id){
    $("#"+element_id).click(function(){	
	location = "/quote/edit/id/0/lead_id/" + $("#lead_id").val();
    });
}



