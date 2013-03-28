function Company_RtoProvider_Fee_Range()
{
    
}

Company_RtoProvider_Fee_Range.prototype.AddValueOnclickBind = function(element)
{
    element.click(function()
    {
	range_id    = $("#range_id").val()
	location    = '/rto-provider-fee-range-value/edit/id/0/range_id/' + range_id;
    });
}
