function ConfigurableProductOption() {
    
}

ConfigurableProductOption.prototype.ValueAddOnclickBind = function(element){
    element.click(function(){
	configurableproductoption_id  = $("#configurableproductoption_id").val()
	location    ='/configurableproductoptionvalue/edit/id/0/configurableproductoption_id/'+configurableproductoption_id;
    });
}

ConfigurableProductOption.prototype.EditOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/configurableproductoption/edit/id/' + button.parent().attr("configurableproductoption_id");
    });
}

ConfigurableProductOption.prototype.AddOnclickBind = function(element){
    element.click(function(){
	location    ='/configurableproductoption/edit/id/0';
    });
}

ConfigurableProductOption.prototype.ViewOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/configurableproductoption/view/id/' + button.parent().attr("configurableproductoption_id");
    });
}

ConfigurableProductOption.prototype.DeleteOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	if(confirm("Are you sure? This will delete the option and ALL of its values!!!!")){
	    location='/configurableproductoption/delete/id/' + button.parent().attr("configurableproductoption_id");
	}
    });
}