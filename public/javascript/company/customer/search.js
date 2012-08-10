function Customer_Search() {
    
}

Customer_Search.prototype.CustomerLookupInit = function(element_id){
    $( "#"+element_id ).autocomplete({
	    source: "/company/customer/searchautocomplete",
	    minLength: 2,
	    select: function( event, ui ) {
		    location="/company/customer/view/id/" + ui.item.id;
	    }
    });
}