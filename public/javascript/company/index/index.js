Company_Index_Index = function()
{
    
}

Company_Index_Index.prototype.clockInOutBind = function(element)
{
    element.click(function(){
	location = "/employee/clock-punch/id/" + element.attr("employee_id");
    });
}


