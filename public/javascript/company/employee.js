function Employee() {
    
}

Employee.prototype.EditOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/company/employee/view/id/' + button.parent().attr("employee_id");
    });
}

Employee.prototype.AddOnclickBind = function(element){
    element.click(function(){
	location    ='/company/employee/edit/id/0';
    });
}

Employee.prototype.AddAddressClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/person/address/edit/id/0/person_id/" + $("#employee_id").val();
    });
}

Employee.prototype.AddPhoneClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/person/phone-number/edit/id/0/person_id/" + $("#employee_id").val();
    });
}

Employee.prototype.AddEmailClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/person/email-address/edit/id/0/person_id/" + $("#employee_id").val();
    });
}

Employee.prototype.AddAccountClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/company/website-account/edit/id/0/person_id/" + $("#employee_id").val();
    });
}

