function Hr_Employee() {
    
}

Hr_Employee.prototype.EditOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/humanresources/employeeview/id/' + button.parent().attr("employee_id");
    });
}

Hr_Employee.prototype.AddOnclickBind = function(element){
    element.click(function(){
	location    ='/employee/add/';
    });
}

Hr_Employee.prototype.AddAddressClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/employee/addaddress/id/" + $("#employee_id").val();
    });
}

Hr_Employee.prototype.AddPhoneClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/employee/addphone/id/" + $("#employee_id").val();
    });
}

Hr_Employee.prototype.AddEmailClickBind = function(element_id){
    $("#"+element_id).click(function(){
	location = "/employee/addemail/id/" + $("#employee_id").val();
    });
}

