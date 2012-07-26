function Product() {
    
}

Product.prototype.ManageOptionsOnclickBind = function(element){
    element.click(function(){
	product_id  = $("#product_id").val()
	location    ='/product/manageoptions/id/'+product_id;
    });
}