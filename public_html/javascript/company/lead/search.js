function Company_Lead_Search() {
    
}

Company_Lead_Search.prototype.LeadLookupInit = function(element_id, url)
{
    $( "#"+element_id ).autocomplete({
	    source: "/lead/searchautocomplete",
	    minLength: 2,
	    select: function( event, ui ) {
		    location = url + ui.item.id;
	    }
    });
}

