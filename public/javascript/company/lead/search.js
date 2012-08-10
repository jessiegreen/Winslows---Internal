function Lead_Search() {
    
}

Lead_Search.prototype.LeadLookupInit = function(element_id){
    $( "#"+element_id ).autocomplete({
	    source: "/company/lead/searchautocomplete",
	    minLength: 2,
	    select: function( event, ui ) {
		    location="/company/lead/view/id/" + ui.item.id;
	    }
    });
}

