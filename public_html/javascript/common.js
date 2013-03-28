var BASE_URL = '/';//TODO: Set this

Common1 = function()
{
    
}

Common1.prototype.inArray = function(needle, haystack)
{
    var length = haystack.length;
    
    for(var i = 0; i < length; i++) 
    {
        if(haystack[i] == needle) return i;
    }
    return false;
}

var Common = new Common1;