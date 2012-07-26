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