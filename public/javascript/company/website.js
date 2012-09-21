function Website() {
    
}

Website.prototype.ViewOnclickBind = function(element)
{
    element.click(function(e)
    {
	button = $(e.target);
	location='/website/index/view/id/' + button.parent().attr("website_id");
    });
}

Website.prototype.AddMenuOnclickBind = function(element)
{
    element.click(function(e)
    {
	button = $(e.target);
	location='/website/menu/edit/id/0/website_id/' + button.parent().attr("website_id");
    });
}

Website.prototype.CleanResourcesOnclickBind = function(element)
{
    element.click(function()
    {
	location='/website/resource/clean/';
    });
}

Website.prototype.BuildResourcesOnclickBind = function(element)
{
    element.click(function()
    {
	location='/website/resource/build/';
    });
}

