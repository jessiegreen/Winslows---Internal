function Employee() {
    
}

Employee.prototype.LocationSelectOnchangeBind = function(company_element_selector, location_element_selector){
    $(company_element_selector).change(function(e){
	element	    = $(e.target);
	value	    = element.val();
	
	Employee.PopulateCompanyOptions(location_element_selector, value);
    });
}

Employee.prototype.PopulateCompanyOptions = function(location_element_selector, company_id){
    $.ajax({
	url: "/employee/getlocationoptionsjson/id/"+ company_id,
	success: function(options){
	    select = $(location_element_selector);
	    console.log(options);
	    options_string = '<option value="">Please select...</option>';
	    $.each(options.data, function(index, value){
		console.log("index="+index+" value="+value);
		options_string = options_string + '<option value="'+index+'">'+value+'</option>';
	    })
	    console.log(options_string+"test");
	    select
		.find('option')
		.remove()
		.end()
		.append(options_string)
		.val('')
	    ;
	}
    });
}
