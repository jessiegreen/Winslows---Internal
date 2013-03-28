Website_Resource_View = function()
{
    
}

Website_Resource_View.prototype.ManageRolesOnclickBind = function(element)
{
    element.click(function(){
	location = "/website-resource/manage-roles/id/" + $("#resource_id").val();
    });
}


