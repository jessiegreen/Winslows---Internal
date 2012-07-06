function Customer() {
    
}

Customer.prototype.CustomerLookupInit = function(element_id){
    $( "#"+element_id ).autocomplete({
	    source: "/customer/searchautocomplete",
	    minLength: 2,
	    select: function( event, ui ) {
		    log( ui.item ?
			    "Selected: " + ui.item.value + " aka " + ui.item.id :
			    "Nothing selected, input was " + this.value );
	    }
    });
}



