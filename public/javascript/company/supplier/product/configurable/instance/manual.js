var Manual = function(instance_id) 
{
    this.local_queue		= $({});
    this.interval		= 0;
    this.count			= 0;
    this.progressbar_element	= $("#progress_bar");
    this.submit_element		= $("input[type=submit]");
    this.cancel_element		= $("#form_cancel");
    this.form_element		= $("#configurable_instance_edit");
    this.error_element		= $("#quote_product_errors");
    this.tabs_container_id	= "#quote_tabs";
    this.tabs_element		= $(this.tabs_container_id);
    this.instance_id		= instance_id;
    this_var			= this;
     
    this.tabs_element.tabs();
    this.submit_element.button({ disabled: true });
    this.cancel_element.button();
    
    this.local_queue.queue(
		    'right_frame', 
		    function(next){
			this_var.progressbar_element.progressbar({
			    value: 100
			}).hide().slideDown(1000);
		    next();}
	    );
}

Manual.prototype.addRequiredAndExistingToOptionsList = function(data, instance_id)
{
    this_var = this;
    
    $.each(data.left, function(category_index, category_data)
    {
	$.each(category_data.options, function(type, option_array)
	{
	    this_var.local_queue.queue('left_frame', function(next)
	    {
		this_var.addOptionToLeftFrame(option_array.id, option_array.name, option_array.maxcount, category_data.category.index);

		next();
	    });
	});
    });
    
    $.each(data.existing, function(index, option_array)
    {
	//--See if option is a required option
	required_index = Common.inArray(option_array.configurable_option.id, data.required);
	//--If is required
	if(required_index !== false)
	{
	    //--Star the Tab to indicate required
	    $("#tab_title_"+option_array.category.id).html(option_array.category.name+"*");
	    //--Remove option id from required as it has now been satisfied 
	    delete data.required[required_index];
	}
	
	this_var.local_queue.queue('right_frame', function(next)
	{
	    this_var.addOptionToRightFrame(
					    instance_id, 
					    option_array.configurable_option.id,
					    option_array.instance_option.id,
					    next
					);

	    this_var.progressbar_element.progressbar({
		value: this_var.progressbar_element.progressbar("value")-this_var.interval
	    });
	});
    });
    
    //--Add the remaining required options to the right frame
    $.each(data.required, function(index, option_id)
    {
	//--Star the Tab to indicate required
	//$("#tab_title_"+option_array.category.id).html(option_array.category.name+"*");
	
	this_var.local_queue.queue('right_frame', function(next)
	{
	    this_var.addOptionToRightFrame(
					    instance_id, 
					    option_id,
					    null,
					    next
					);

	    this_var.progressbar_element.progressbar({
		value: this_var.progressbar_element.progressbar("value")-this_var.interval
	    });
	});
    });
    
    //--Set progress bar interval
    this.count	    = this.local_queue.queue('right_frame').length;
    this.interval   = 100/this.count;
    
    //--Clean up progress bar, enable save button, initialize drag and drop on left items
    this.local_queue.queue('right_frame', function(next)
    {
	this_var.progressbar_element.slideUp(1000, function(){this_var.progressbar_element.html("")});
	this_var.submit_element.button({ disabled: false });
	Manual.dragAndDropInit(this_var.instane_id);
	next();
    });
    
    //--Add left queue start to the end of the left queue
    this.local_queue.queue('left_frame', function(next)
    {
	this_var.local_queue.dequeue('right_frame');
	next();
    });
    
    //--start left queue
    this.local_queue.dequeue('left_frame');
}

Manual.prototype.submit = function(instance_id, return_url)
{
    this_var = this;
    
    this.form_element.submit(function()
    {
	$.post(
	    "/company/supplier-product-configurable-instance/manualsaveajax/id/"+instance_id, 
	    this_var.form_element.serialize(),
	    function(data) {
		if(data.success === true){
		    parent.location = return_url;
		}
		else if(data.success === false){
		    if(data.error_message){
			this_var.error_element.fadeOut("fast", function(){
			    this_var.error_element.html(data.error_message);
			    this_var.error_element.fadeIn("fast");
			});
		    }
		}
	    },
	    "json"
	)
	.error( function (jqXHR, status, error) {
	    alert(error)
	 })
	.complete(function() { });
	return false;
    });
}

Manual.prototype.cancel = function(return_url)
{
    this.cancel_element.click(function(){location = return_url;});
}

Manual.prototype.dragAndDropInit = function()
{
    this_var = this;
    
    $(".add_option_left li").draggable({
	cursor: "move",
	helper:	"clone",
	containment: this_var.tabs_container_id,
	drag: function(){
	    $(".add_option_right").css("border", "solid 1px blue");
	},
	stop: function(){
	    $(".add_option_right").css("border", "1px solid #EEEDED");
	}
    });

    $('.add_option_right').droppable( {
	drop: handleDropEvent
    });

    function handleDropEvent( event, ui )
    {
	var draggable   = ui.draggable;
	option_id	= draggable.attr('option_id');

	this_var.addOptionToRightFrame(this_var.instance_id, option_id);
    }
    
}

Manual.prototype.addOptionToRightFrame = function(instance_id, configurable_option_id, instance_option_id, next)
{
    instance_url = instance_option_id ? "/option_id/"+instance_option_id : "";
	
    $.ajax(
    {
	url: "/company/supplier-product-configurable-instance/getoptionform/id/"+
	    instance_id+"/configurable_option_id/"+configurable_option_id+instance_url,
	success: function(data)
	{
	    left_option_li  = $("#draggable_"+configurable_option_id);
	    quantity_left   = left_option_li.attr('quantity_left');
	    parent_div	    = left_option_li.parents(".category_div");
	    right_div	    = parent_div.children(".add_option_right");
	    
	    right_div.append(data).children(':last').hide().fadeIn(1000);
	    
	    if(quantity_left == 0){
		left_option_li.fadeOut(1000, function(){left_option_li.remove()});
	    }
	    else{
		left_option_li.attr('quantity_left', quantity_left-1);
	    }
	    
	    if(next)next();
	}
    });
}

Manual.prototype.addOptionToLeftFrame = function(option_id, option_name, option_maxcount, category_index)
{
    option_list = $("#optional_list_"+category_index);
    option_list.append('<li quantity_left="'+(option_maxcount-1)+'" option_id="'+option_id+'" id="draggable_'+
	    option_id+'" style="cursor: move;">'+option_name+'</li>');
}