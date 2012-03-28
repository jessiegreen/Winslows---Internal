function Option() {
    
}

Option.prototype.AddOnclickBind = function(element){
    element.click(function(){
	location='/codebuilder/optionedit';
    });
}

Option.prototype.EditOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/codebuilder/optionedit/id/' + button.parent().attr("option_id");
    });
}

Option.prototype.AddValueOnclickBind = function(element){
    element.click(function(e){
	element = $(e.target);
	location='/codebuilder/valueedit/option_id/' + element.parent().attr("option_id");
    });
}

Option.prototype.AddValueOptionOnclickBind = function(element){
    element.click(function(e){
	element = $(e.target);
	location='/codebuilder/valueoptionedit/value_id/' + element.parent().attr("value_id");
    });
}

Option.prototype.ShowValueOnclickBind = function(element){
    element.click(function(e){
	element = $(e.target);
	$("#values_container_"+element.parent().attr("option_id")).toggle();
    });
}

Option.prototype.ShowAllOnclickBind = function(element){
    element.click(function(){
	$("[id^='values_container_']").show();
    });
}

Option.prototype.HideAllOnclickBind = function(element){
    element.click(function(){
	$("[id^='values_container_']").hide();
    });
}

Option.prototype.DeleteValueOnclickBind = function(element){
    element.click(function(e){
	element = $(e.target);
	if(confirm("Are you sure you want to delete this value?"))
	{
	    location='/codebuilder/valuedelete/value_id/' + element.parent().attr("value_id");
	}
    });
}

Option.prototype.EditValueOnclickBind = function(element){
    element.click(function(e){
	element = $(e.target);
	location='/codebuilder/valueedit/value_id/' + element.parent().attr("value_id");
    });
}

Option.prototype.DeleteValueOptionOnclickBind = function(element){
    element.click(function(e){
	element = $(e.target);
	if(confirm("Are you sure you want to delete this value option?"))
	{
	    location='/codebuilder/valueoptiondelete/valueoption_id/' + element.parent().attr("valueoption_id");
	}
    });
}

Option.prototype.EditValueOptionOnclickBind = function(element){
    element.click(function(e){
	element = $(e.target);
	location='/codebuilder/valueoptionedit/valueoption_id/' + element.parent().attr("valueoption_id");
    });
}