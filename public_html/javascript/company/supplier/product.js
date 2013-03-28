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

Product.prototype.ManageDeliveryTypesOnclickBind = function(element)
{
    element.click(function()
    {
	product_id  = $("#product_id").val()
	location    = '/supplier-product/manage-delivery-types/id/' + product_id;
    });
}

Product.prototype.DeliveryTypeAddOnclickBind = function(element)
{
    element.click(function()
    {
	product_id  = $("#product_id").val()
	location    = '/supplier-product-delivery-type/edit/id/0/product_id/' + product_id;
    });
}

Product.prototype.PurposeAddOnclickBind = function(element)
{
    element.click(function()
    {
	product_id  = $("#product_id").val()
	location    = '/supplier-product-purpose/edit/id/0/product_id/' + product_id;
    });
}

Product.prototype.ImageAddOnclickBind = function(element)
{
    element.click(function()
    {
	product_id  = $("#product_id").val()
	location    = '/supplier-product-file-image/edit/id/0/product_id/' + product_id;
    });
}