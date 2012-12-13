function Company_Supplier_Product_Category()
{
    
}

Company_Supplier_Product_Category.prototype.AddImageOnclickBind = function(element)
{
    element.click(function()
    {
	category_id  = $("#category_id").val()
	location    = '/supplier-product-category-file-image/edit/id/0/category_id/' + category_id;
    });
}

