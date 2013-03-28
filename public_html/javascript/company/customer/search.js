function Customer_Search() {
    
}

Customer_Search.prototype.CustomerLookupInit = function(element_id){
    $( "#"+element_id ).autocomplete({
	    source: "/customer/searchautocomplete",
	    minLength: 2,
	    select: function( event, ui ) {
		    location="/customer/view/id/" + ui.item.id;
	    }
    });
}