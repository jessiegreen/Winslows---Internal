function Lead() {
    
}

Lead.prototype.LeadLookupInit = function(element_id){
    $( "#"+element_id ).autocomplete({
	    source: "/lead/searchautocomplete",
	    minLength: 2,
	    select: function( event, ui ) {
		    location="/lead/view/id/" + ui.item.id;
	    }
    });
}

Lead.prototype.AddAddressClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/lead/addaddress/id/" + $("#lead_id").val();
    });
}

Lead.prototype.AddPhoneClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/lead/addphone/id/" + $("#lead_id").val();
    });
}

Lead.prototype.AddEmailClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/lead/addemail/id/" + $("#lead_id").val();
    });
}

Lead.prototype.AddContactClickBind = function(element_id){
    $("#"+element_id).click(function(){
	selected	= $('#contact_type_id_select option:selected');
	type_id		= selected.val();
	
	if(type_id.length > 0){
	    type	= selected.attr("type_string");
	    location	= "/lead/addcontact/id/" + $("#lead_id").val()+"/type/"+type+"/type_id/"+type_id;
	}
//	location	= "/lead/addcontact/id/" + $("#lead_id").val();
    });
}



