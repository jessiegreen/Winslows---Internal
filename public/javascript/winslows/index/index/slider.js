function Winslows_Index_Index_Slider()
{
    this.slider          = $("#product-slider");
    this.left_arrow      = $("#left-arrow");
    this.left_arrow_red  = $("#left-arrow-red");
    this.right_arrow     = $("#right-arrow");
    this.right_arrow_red = $("#right-arrow-red");
}

Winslows_Index_Index_Slider.prototype.init = function(count)
{
    var width           = (parseInt(count) - 10) * 96;
    this_var            = this;
    
    this.swap_arrows(width);
    
    $(".product-slider-left-arrow").hover(
        function()
        {
            speed = ((parseInt($("#product-slider").css("left"))*-1) * 4);
            
            this_var.left_arrow.show();
            this_var.left_arrow_red.hide();
            this_var.slider.stop().animate({left:"0px"},{queue:false,duration:speed, complete:function(){this_var.swap_arrows(width)}});
        },
        function(){
            this_var.slider.stop();
        }
    );
    $(".product-slider-right-arrow").hover(
        function()
        {
            speed = ((parseInt($("#product-slider").css("left"))+960) * 4);
            
            this_var.right_arrow.show();
            this_var.right_arrow_red.hide(); 
            this_var.slider.stop().animate({left:"-" + width + "px"},{queue:false,duration:speed, complete:function(){this_var.swap_arrows(width)}});
        },
        function(){
            this_var.slider.stop();
        }
    );
}

Winslows_Index_Index_Slider.prototype.swap_arrows = function(width)
{
    if(this.slider.css("left") == "0px")
    {
        this.left_arrow.hide();
        this.left_arrow_red.show();
    }
    else
    {
        this.left_arrow.show();
        this.left_arrow_red.hide(); 
    }
    if(this.slider.css("left") == "-" + width + "px")
    {
        this.right_arrow.hide();
        this.right_arrow_red.show();
    }
    else
    {
        this.right_arrow.show();
        this.right_arrow_red.hide(); 
    }
}
