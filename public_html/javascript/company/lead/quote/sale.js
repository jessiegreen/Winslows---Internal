function Company_Lead_Quote_Sale()
{
    
}

Company_Lead_Quote_Sale.prototype.AddPaymentOnClickBind = function(element)
{
    element.click(function(e)
    {	
	location = "/lead-quote-sale-transaction-payment/"+$(this).val()+"/sale_id/" + $("#sale_id").val();
    })
}