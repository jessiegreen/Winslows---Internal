function Builder() {
    
}

Builder.prototype.update = function(code,price,hints,details,price_details){
    $("#builder_code").html(code);
    $("#builder_price").html("$"+price);
    $('#builder_details').html(details);
    $('#price_details').html(price_details);
    //Any ajax must be done after this
    $("#builder_hints").hide("slide", {direction: "up"}, 500, function(){
	$("#builder_hints").html("");
	    if(hints.length > 0){
	    jQuery.each(hints, function() {
		$("#builder_hints").append("<div><img style='position:relative;top:3px;' src='/img/icons/lightbulb.png' />"+this+"</div>");
	    });
	}
	$("#builder_hints").show("slide", {direction: "up"}, 500);
	b = new Builder;
	b.add_flash_message_from_messenger();
    });
}

Builder.prototype.add_flash_message_from_messenger = function(){
    $.ajax({
	url:"/builder/messenger/",
	success:function(data){
	    if(data.length>0){
		d	    = new Date();
		seconds	    = d.getMilliseconds();
		minutes	    = d.getMinutes();
		b	    = new Builder;
		b.add_flash_message(data,minutes+seconds);
	    }
	}
    });
}

Builder.prototype.add_flash_message = function(data,index){
    message = $("<div id='message_"+index+"'><img style='position:relative;top:3px;float:left;' src='/img/icons/exclamation.png' />"+data+"</div>");
    message.hide().appendTo("#builder_hints").show("slide", {direction: "up"}, 500,function(){
	    setTimeout(function(){
		    $("#message_"+index).hide("slide", {direction: "up"}, 500, function(){$("#message_"+index).remove()});
	    }, 2000);
	});
}

Builder.prototype.map_click_bind = function(){
    //Get maps image map areas and add click function
    $("#map_map").children("area").click(function(e){
	//Get the value of the clicked area
	var tab_area = $(e.target).attr("location_value");
	if(tab_area != "undefined"){
	    //Set the area
	    $.ajax({
		url:"/builder/location/set/"+tab_area,
		success:function(data){
		    $("#Location").html(data);
		}
	    });
	}
    });
}

Builder.prototype.type_click_bind = function(){
    $("#form_type > *").click(function(e){
	//Get the value of the clicked area
	var selected = $(e.target).val();
	if(selected != "undefined"){
	    //Set the area
	    $.ajax({
		url:"/builder/type/set/"+selected,
		success:function(data){
		    $("#Type").html(data);
		    //$("#example").tabs( "select" , "Type" )
		}
	    });
	}
    });
}

Builder.prototype.model_click_bind = function(){
    $("#form_model > *").click(function(e){
	//Get the value of the clicked area
	var selected = $(e.target).val();
	if(selected != "undefined"){
	    //Set the area
	    $.ajax({
		url:"/builder/model/set/"+selected,
		success:function(data){
		    $("#Model").html(data);
		    //$("#example").tabs( "select" , "Type" )
		}
	    });
	}
    });
}

Builder.prototype.size_click_bind = function(){
    $("#form_size :input").click(function(e){
	var selected = $(e.target).val();
	if(selected != "undefined"){
	    //Set the area
	    $.ajax({
		type: "POST",
		data:$('#form_size').serialize(),
		url:"/builder/size/",
		success:function(data){
		    $("#Size").html(data);
		}
	    });
	}
    });
}

Builder.prototype.walls_click_bind = function(){
    $('input[name^="builder_walls_"]').click(function(e){
	//Get the value of the clicked area
	var selected = $(e.target).val();
	if(selected != "undefined"){
	    //Set the area
	    $.ajax({
		type: "POST",
		data:$('#form_walls').serialize(),
		url:"/builder/walls/",
		success:function(data){
		    $("#Walls").html(data);
		}
	    });
	}
    });
}

Builder.prototype.reset_click_bind = function(){
    $('#reset').button();
    $('#reset').click(function(){
	$('#dirty').load('/builder/clear',function(){
		setTimeout(function(){
		    selected = $('#example').tabs('option', 'selected');
		    if(selected != 0)$('#example').tabs('select', 'Location');
		    else $('#example').tabs('load', 0);
		}, 1500);
	    }
	);
    });
}

Builder.prototype.colors_click_bind = function(){
    //Get maps image map areas and add click function
    $('map[name^="colorpicker"]').children("area").click(function(e){
	//Get the value of the clicked area
	var color = $(e.target).attr("target");
	var side = $(e.target).parent().attr("side");
	if(color != "undefined"){
	    //Set the area
	    $.ajax({
		url:"/builder/colors/side/"+side+"/set/"+color,
		success:function(data){
		    $("#Colors").html(data);
		}
	    });
	}
    });
}

Builder.prototype.doors_init = function(){

    $( "#location_radios" ).buttonset();
    $( "#size_utility" ).buttonset();
    $( "#size_utility" ).hide();
    $( "#size_rollup" ).buttonset();
    $( "#size_rollup" ).hide();
    $( "#door_add" ).button();
    $( "#door_add" ).click(function(){
	
	data		= $('#doors_form').serialize();
	var data_array	= {};
	message		= "";
	
	$.each($('#doors_form').serializeArray(), function(i, field) {
	    data_array[field.name] = field.value;
	});
	
	if(!data_array["type"])message = message + "Please choose a type of door to add.";
	else if(!data_array["size"])message = message + "Please choose the size of door to add.";
	else if(!data_array["location"])message = message + "Please choose the location on the building you would like to add the door.";
	if(message.length>0){
	    dialog = $('<div></div>')
		.html(message)
		.dialog({
		    resizable: false,
		    height:170,
		    modal: true,
		    autoOpen:false,
		    buttons: {
			"Ok": function() {
				$( this ).dialog( "close" );
			}
		    }
		});
		dialog.dialog('open');
	}
	else{
	    $.ajax({
		type: "POST",
		data:data,
		url:"/builder/doors/",
		success:function(data){
		    $("#Doors").html(data);
		}
	    });
	}
    });
    
    $(".current_doors_list").click(function(e){
	element = $(e.target);
	data	= {"delete" : element.attr("id")};
	dialog = $('<div></div>')
		.html('Are you sure you want to delete this door?')
		.dialog({
		    resizable: false,
		    height:170,
		    modal: true,
		    autoOpen:false,
		    buttons: {
			"Delete Door": function() {
				$( this ).dialog( "close" );
				$.ajax({
				    type: "POST",
				    data:data,
				    url:"/builder/doors/",
				    success:function(data){
					$("#Doors").html(data);
				    }
				});
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		    }
		});
		dialog.dialog('open');
    });
    $('.colorpicker_images').maphilight({strokeWidth: 3,fillColor:"C0A55E",strokeColor:"F9E482"});
    $('#doors_map').children("area").click(function(e){
      //AREAS LOOP:
       $(".tabs area").each(function(){
           var d = $(this).data('maphilight') || {};
           if(d.alwaysOn == true){
             d.alwaysOn = false;  
           }
         });
	 
	//This block is what creates highlighting by trigger the "alwaysOn",
	var data = $(this).data('maphilight') || {};
	data.alwaysOn = true;  //NOTICE I MADE THIS ALWAYS TRUE
	$(this).data('maphilight', data).trigger('alwaysOn.maphilight');
	//there is also "neverOn" in the docs, but not sure how to get it to work


	if ($(this).hasClass("current") == false)
	{
	    value = $(this).attr("code");
	    if(value == "OS"){
		$("#size_utility").show();
		$("#size_rollup").hide();
	    }
	    else if(value == "RU"){
		$("#size_rollup").show();
		$("#size_utility").hide();
	    }
	    $("#door_type").val(value);
	}
	return false;

    });
}

Builder.prototype.windows_init = function(){

    $( "#window_location_radios" ).buttonset();
    $( "#window_add" ).button();
    $( "#window_add" ).click(function(){
	
	data		= $('#windows_form').serialize();
	var data_array	= {};
	message		= "";
	
	$.each($('#windows_form').serializeArray(), function(i, field) {
	    data_array[field.name] = field.value;
	});
	
	if(!data_array["type"])message = message + "Please choose a type of window to add.";
	else if(!data_array["size"])message = message + "Please choose the size of window to add.";
	else if(!data_array["location"])message = message + "Please choose the location on the building you would like to add the window.";
	if(message.length>0){
	    dialog = $('<div></div>')
		.html(message)
		.dialog({
		    resizable: false,
		    height:170,
		    modal: true,
		    autoOpen:false,
		    buttons: {
			"Ok": function() {
				$( this ).dialog( "close" );
			}
		    }
		});
		dialog.dialog('open');
	}
	else{
	    $.ajax({
		type: "POST",
		data:data,
		url:"/builder/windows/",
		success:function(data){
		    $("#Windows").html(data);
		}
	    });
	}
    });
    
    $(".current_windows_list").click(function(e){
	element = $(e.target);
	data	= {"delete" : element.attr("id")};
	dialog = $('<div></div>')
		.html('Are you sure you want to delete this window?')
		.dialog({
		    resizable: false,
		    height:170,
		    modal: true,
		    autoOpen:false,
		    buttons: {
			"Delete Window": function() {
				$( this ).dialog( "close" );
				$.ajax({
				    type: "POST",
				    data:data,
				    url:"/builder/windows/",
				    success:function(data){
					$("#Windows").html(data);
				    }
				});
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		    }
		});
		dialog.dialog('open');
    });
}