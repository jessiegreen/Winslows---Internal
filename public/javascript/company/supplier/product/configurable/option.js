function ConfigurableProductOptionGroup() {
    
}

ConfigurableProductOptionGroup.prototype.ManageOptionsOnclickBind = function(element){
    element.click(function(){
	configurableproductoptiongroup_id  = $("#configurableproductoptiongroup_id").val()
	location    ='/configurableproductoptiongroup/manageoptions/id/'+configurableproductoptiongroup_id;
    });
}

ConfigurableProductOptionGroup.prototype.OptionAddOnclickBind = function(element){
    element.click(function(){
	configurableproductoptiongroup_id  = $("#configurableproductoptiongroup_id").val()
	location    ='/configurableproductoption/edit/id/0/configurableproductoptiongroup_id/'+configurableproductoptiongroup_id;
    });
}

ConfigurableProductOptionGroup.prototype.EditOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/configurableproductoptiongroup/edit/id/' + button.parent().attr("configurableproductoptiongroup_id");
    });
}

ConfigurableProductOptionGroup.prototype.AddOnclickBind = function(element){
    element.click(function(){
	location    ='/configurableproductoptiongroup/edit/id/0';
    });
}

ConfigurableProductOptionGroup.prototype.ViewOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/configurableproductoptiongroup/view/id/' + button.parent().attr("configurableproductoptiongroup_id");
    });
}

ConfigurableProductOptionGroup.prototype.DeleteOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	if(confirm("Stop!! Are you sure you want to delete this group? IT WILL DELETE ALL OPTIONS AND VALUES ATTACHED TO IT! This can not be undone!!")){
	    location='/configurableproductoptiongroup/delete/id/' + button.parent().attr("configurableproductoptiongroup_id");
	}
    });
}