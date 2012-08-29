function RtoProvider()
{
    
}

RtoProvider.prototype.EditOnclickBind = function(element)
{
    element.click(function(e)
    {
	button = $(e.target);
	location='/rtoProvider/index/view/id/' + button.parent().attr("rto_provider_id");
    });
}

RtoProvider.prototype.AddOnclickBind = function(element)
{
    element.click(function()
    {
	location    ='/rtoProvider/index/edit/id/0';
    });
}

RtoProvider.prototype.ManageProductsOnclickBind = function(element)
{
    element.click(function()
    {
	rto_provider_id  = $("#rto_provider_id").val()
	location    ='/rtoProvider/index/manage-products/id/'+rto_provider_id;
    });
}

