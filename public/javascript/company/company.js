function Company() {
    
}

Company.prototype.CompanyLookupInit = function(element_id){
    $( "#"+element_id ).autocomplete({
	    source: "/company/searchautocomplete",
	    minLength: 2,
	    select: function( event, ui ) {
		    location="/company/edit/id/" + ui.item.id;
	    }
    });
}

Company.prototype.AddAddressClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/company/addaddress/id/" + $("#company_id").val();
    });
}

Company.prototype.AddPhoneClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/company/addphone/id/" + $("#company_id").val();
    });
}

Company.prototype.AddEmailClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/company/addemail/id/" + $("#company_id").val();
    });
}

Company.prototype.AddContactClickBind = function(element_id){
    $("#"+element_id).click(function(){
	selected	= $('#contact_type_id_select option:selected');
	type_id		= selected.val();
	
	if(type_id.length > 0){
	    type	= selected.attr("type_string");
	    location	= "/company/addcontact/id/" + $("#company_id").val()+"/type/"+type+"/type_id/"+type_id;
	}
//	location	= "/company/addcontact/id/" + $("#company_id").val();
    });
}



