<?php
namespace Dataservice\Html;

class Button 
{
    private static $_icon_url = "/img/icons/";
    
    public static function buttonBlue($icon, $text, $id = "", $style = "", $class = "", $attr="")
    {
	return "<div class='button_blue $class' id='$id' style='$style' ".$attr.">".self::button_icon(array("icon" => $icon), false)." $text</div>";
    }
    
    public static function buttonIcon($icon, $id = "", $title = "", $class = "", $style = "", $attr="")
    {
	return '<img src="/img/icons/'.$icon.'" class="button_icon '.$class.'" style="'.$style.'" id="'.$id.'" title="'.$title.'" '.$attr.'/>';
    }
    
    private static function button_icon($data_array, $float_left = true)
    {
	if(isset($data_array['icon']))
	{
	    $icon_url = self::$_icon_url.$data_array['icon'];
	    
	    if(file_exists(PUBLIC_PATH.$icon_url))
	    {
		return '<img src="'.$icon_url.'" style="'.($float_left ? 'float:left;' : '').'margin-right:5px;vertical-align:bottom;" />';
	    }
	    else return '';
	}
    }
}
