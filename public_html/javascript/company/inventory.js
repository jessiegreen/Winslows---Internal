function Company_Inventory()
{
    
}

//Company_Inventory.prototype.EditOnclickBind = function(element)
//{
//    element.click(function(e)
//    {
//	button = $(e.target);
//	location='/dealer/view/id/' + $("#dealer_id").val();
//    });
//}
//
//Company_Inventory.prototype.AddOnclickBind = function(element)
//{
//    element.click(function()
//    {
//	location    ='/dealer/edit/id/0';
//    });
//}

Company_Inventory.prototype.AddItemOnclickBind = function(element)
{
    element.click(function()
    {
	inventory_id	= $("#inventory_id").val();
	product_id	= $("#product_select").val();
	location	= '/inventory/add-item/id/' + inventory_id + '/product_id/' + product_id;
    });
}

