<?php
namespace Dataservice\Html;

class Anchor 
{
    private static $_icon_url = "/img/icons/";
    
    public static function anchorIcon($icon, $text, $href, $style = "", $title = "", $id = "")
    {
	return '<a href="'.$href.'" title="'.$title.'" style="border:none;'.$style.'" id="'.$id.'">'.
		    '<img src="'.self::$_icon_url.'/'.$icon.'"/ style="margin-right:5px;vertical-align:bottom;">'.
		    $text.
		'</a>';
    }
    
    public static function backAnchorIcon($text, $href)
    {
	return self::anchorIcon("arrow_left.png", $text, $href,"", "back");
    }
}
