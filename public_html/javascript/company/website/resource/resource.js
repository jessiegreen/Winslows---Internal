function Resource() {
    
}

Resource.prototype.EditOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/website/resource/manage-roles/id/' + button.parent().attr("resource_id");
    });
}

