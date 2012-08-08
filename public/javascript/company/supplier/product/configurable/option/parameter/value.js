function ConfigurableProductOptionValue() {
    
}

ConfigurableProductOptionValue.prototype.EditOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/configurableproductoptionvalue/edit/id/' + button.parent().attr("configurableproductoptionvalue_id");
    });
}

ConfigurableProductOptionValue.prototype.DeleteOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	if(confirm("Are you sure you want to delete this value? This can not be undone!")){
	    location='/configurableproductoptionvalue/delete/id/' + button.parent().attr("configurableproductoptionvalue_id");
	}
    });
}

ConfigurableProductOptionValue.prototype.AddOnclickBind = function(element){
    element.click(function(){
	location    ='/configurableproductoptionvalue/edit/id/0';
    });
}