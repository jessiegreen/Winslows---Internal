function Company_Dealer()
{
    
}

Company_Dealer.prototype.EditOnclickBind = function(element)
{
    element.click(function(e)
    {
	button = $(e.target);
	location='/dealer/view/id/' + $("#dealer_id").val();
    });
}

Company_Dealer.prototype.AddOnclickBind = function(element)
{
    element.click(function()
    {
	location    ='/dealer/edit/id/0';
    });
}

Company_Dealer.prototype.AddLocationOnclickBind = function(element)
{
    element.click(function()
    {
	dealer_id  = $("#dealer_id").val()
	location    ='/dealer-location/edit/id/0/dealer_id/' + dealer_id;
    });
}

