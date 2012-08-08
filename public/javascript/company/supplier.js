function Supplier() {
    
}

Supplier.prototype.EditOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/company-supplier/view/id/' + button.parent().attr("supplier_id");
    });
}

Supplier.prototype.AddOnclickBind = function(element){
    element.click(function(){
	location    ='/company-supplier/edit/id/0';
    });
}

Supplier.prototype.AddAddressOnclickBind = function(element){
    element.click(function(){
	location    ='/company-supplier-address/edit/id/0/supplier_id/'+$("#supplier_id").val();
    });
}

Supplier.prototype.AddCompanyOnclickBind = function(element){
    element.click(function(){
	location    ='/company-supplier/addcompany/id/'+$("#supplier_id").val();
    });
}

Supplier.prototype.AddProductOnclickBind = function(element){
    element.click(function(){
	location    ='/product/edit/id/0/supplier_id/'+$("#supplier_id").val();
    });
}
