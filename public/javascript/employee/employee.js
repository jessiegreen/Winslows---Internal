function Employee() {
    
}

Employee.prototype.EditOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/employee/view/id/' + button.parent().attr("employee_id");
    });
}

Employee.prototype.AddOnclickBind = function(element){
    element.click(function(){
	location    ='/employee/edit/id/0';
    });
}

Employee.prototype.AddAddressClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/personaddress/edit/id/0/person_id/" + $("#employee_id").val();
    });
}

Employee.prototype.AddPhoneClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/personphonenumber/edit/id/0/person_id/" + $("#employee_id").val();
    });
}

Employee.prototype.AddEmailClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/personemailaddress/edit/id/0/person_id/" + $("#employee_id").val();
    });
}

Employee.prototype.AddWebAccountClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/webaccount/edit/id/0/person_id/" + $("#employee_id").val();
    });
}

