function Winslows_Index_Index_Banner()
{
    this.i      = 0;
    this.array  = "";
    this.count  = 0;
    this.cont   = $("#winslows-header-slideshow-content");
    this.bullets_cont   = $("#bullets-container");
    this.on     = 1;
}

Winslows_Index_Index_Banner.prototype.init = function(html_array)
{
    this.array   = html_array;
    this.count   = html_array.length;
    
    this.create_bullets();
    this.swap_image();
    this.timer();
}

Winslows_Index_Index_Banner.prototype.timer = function()
{
    var this_var = this;
    
        setTimeout(
            function()
            {
                if(this_var.on === 1)
                {
                    this_var.swap_image();
                    this_var.i++;
                    if(this_var.i == this_var.count)this_var.i = 0;
                    this_var.timer();
                }
            }, 5000
        );
}

Winslows_Index_Index_Banner.prototype.swap_image = function(clicked_id)
{
    var this_var2   = this;
    var i3          = typeof clicked_id === 'undefined' ? "test" : clicked_id;
    
    if(i3 === "test" || i3 !== this.i)
    {
        this.cont.fadeOut(500, function()
        {
            if(i3 === "test")
            {
                this_var2.cont.html(this_var2.array[this_var2.i]);
            }
            else
            {
                this_var2.cont.html(this_var2.array[i3]);
                this_var2.i = i3;
            }    
            
            this_var2.cont.fadeIn(500);
            this_var2.update_bullets();
        });
    }
}

Winslows_Index_Index_Banner.prototype.create_bullets = function()
{
    var this_var3 = this;
    
    for(i2 = 0; i2 < this.count; i2++)
    {
        div = $("<div>", {id:"bullet_" + i2});
    
        div.addClass("banner-bullets");
        div.addClass("bullet-unselected");
        
        div.attr("bullet_id", i2);
        
        this.bullets_cont.append(div);
    }
    
    $(".banner-bullets").click(function(e)
    {
        element = $(e.target);
        
        this_var3.swap_image(parseInt(element.attr("bullet_id")));
        this_var3.on = 0;
    });
    
    this.on = this_var3.on;
}

Winslows_Index_Index_Banner.prototype.update_bullets = function()
{
    $(".banner-bullets").removeClass("bullet-selected");
    $(".banner-bullets").addClass("bullet-unselected");
    $("#bullet_" + this.i).removeClass("bullet-unselected").addClass("bullet-selected");
}

