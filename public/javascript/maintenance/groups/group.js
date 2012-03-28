function Group() {
    
}

Group.prototype.AddOnclickBind = function(element){
    element.click(function(){
	location='/maintenance/groupedit';
    });
}

Group.prototype.EditOnclickBind = function(element){
    element.click(function(e){
	button = $(e.target);
	location='/maintenance/groupedit/id/' + button.parent().attr("group_id");
    });
}

Group.prototype.AddPrivilegeOnclickBind = function(element){
    element.click(function(e){
	element = $(e.target);
	location='/maintenance/privilegeedit/group_id/' + element.parent().attr("group_id");
    });
}

Group.prototype.ShowPrivilegeOnclickBind = function(element){
    element.click(function(e){
	element = $(e.target);
	$("#privileges_container_"+element.parent().attr("group_id")).slideToggle();
    });
}

Group.prototype.DeletePrivilegeOnclickBind = function(element){
    element.click(function(e){
	element = $(e.target);
	if(confirm("Are you sure you want to delete this privilege?"))
	{
	    location='/maintenance/privilegedelete/privilege_id/' + element.parent().attr("privilege_id");
	}
    });
}

Group.prototype.EditPrivilegeOnclickBind = function(element){
    element.click(function(e){
	element = $(e.target);
	location='/maintenance/privilegeedit/privilege_id/' + element.parent().attr("privilege_id");
    });
}
