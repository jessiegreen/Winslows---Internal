function Customer() {
    
}

Customer.prototype.CustomerLookupInit = function(element_id){
    $( "#"+element_id ).autocomplete({
	    source: "/customer/searchautocomplete",
	    minLength: 2,
	    select: function( event, ui ) {
		    location="/customer/edit/id/" + ui.item.id;
	    }
    });
}

Customer.prototype.AddAddressClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/customer/addaddress/id/" + $("#customer_id").val();
    });
}

Customer.prototype.AddPhoneClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/customer/addphone/id/" + $("#customer_id").val();
    });
}

Customer.prototype.AddEmailClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/customer/addemail/id/" + $("#customer_id").val();
    });
}

Customer.prototype.AddContactClickBind = function(element_id){
    $("#"+element_id).click(function(){
	selected	= $('#contact_type_id_select option:selected');
	type_id		= selected.val();
	
	if(type_id.length > 0){
	    type	= selected.attr("type_string");
	    location	= "/customer/addcontact/id/" + $("#customer_id").val()+"/type/"+type+"/type_id/"+type_id;
	}
//	location	= "/customer/addcontact/id/" + $("#customer_id").val();
    });
}



