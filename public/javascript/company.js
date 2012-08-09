function Company() {
    
}

Company.prototype.EditOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/company/index/view/id/' + button.parent().attr("company_id");
    });
}

Company.prototype.AddOnclickBind = function(element){
    element.click(function(){
	location    ='/company/index/edit/id/0';
    });
}

Company.prototype.AddLocationOnclickBind = function(element){
    element.click(function(){
	company_id  = $("#company_id").val()
	location    ='/company/location/edit/id/0/company_id/'+company_id;
    });
}

