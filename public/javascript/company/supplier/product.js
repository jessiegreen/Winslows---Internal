function Product()
{
    
}

Product.prototype.ManageOptionGroupsOnclickBind = function(element)
{
    element.click(function()
    {
	product_id  = $("#product_id").val()
	location    ='/supplier-product/manageoptiongroups/id/'+product_id;
    });
}

Product.prototype.OptionGroupAddOnclickBind = function(element)
{
    element.click(function()
    {
	product_id  = $("#product_id").val()
	location    = '/supplier-product-configurable-option/edit/id/0/configurableproduct_id/' + product_id;
    });
}

Product.prototype.ManageCategoriesOnclickBind = function(element)
{
    element.click(function()
    {
	product_id  = $("#product_id").val()
	location    = '/supplier-product/manage-categories/id/' + product_id;
    });
}

Product.prototype.CategoryAddOnclickBind = function(element)
{
    element.click(function()
    {
	product_id  = $("#product_id").val()
	location    = '/supplier-product-category/edit/id/0/product_id/' + product_id;
    });
}