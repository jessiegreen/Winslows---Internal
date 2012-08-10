function Product() {
    
}

Product.prototype.ManageOptionGroupsOnclickBind = function(element){
    element.click(function(){
	product_id  = $("#product_id").val()
	location    ='/company/supplier-product/manageoptiongroups/id/'+product_id;
    });
}

Product.prototype.OptionGroupAddOnclickBind = function(element){
    element.click(function(){
	product_id  = $("#product_id").val()
	location    ='/company/supplier-product-configurable-option/edit/id/0/configurableproduct_id/'+product_id;
    });
}