<?php
namespace Dataservice\Html;

class Anchor 
{
    private static $_icon_url = "/img/icons";
    
    /**
     * 
     * @param string $icon
     * @param string $text
     * @param string $href
     * @param string $style
     * @param string $title
     * @param string $id
     * @param string $onclick
     * @return string
     */
    public static function anchorIcon($icon, $text, $href, $style = "", $title = "", $id = "", $onclick = "")
    {
	$preset_style	= "border:none;font-weight:500;text-decoration:none;font-size:12px;color:gray;";
	
	$span_style	= $text ? "border:solid 1px #E9E9E9;padding:2px;padding-left:4px;border-left:none;border-right:none;margin-left:-7px;" : "";
	
	return '<a href="'.$href.'" title="'.$title.'" style="'.$preset_style.$style.'" id="'.$id.'" onclick="'.$onclick.'">'.
		    '<img src="'.self::$_icon_url.'/'.$icon.'"/ style="margin-right:5px;margin-left:5px;vertical-align:bottom;">'.
		    '<span style="'.$span_style.'">'.$text.'</span>'.
		'</a>';
    }
    
    /**
     * 
     * @param string $text
     * @param string $href
     * @param string $title
     * @param string $id
     */
    public static function editIcon($text, $href, $title = "", $id = "")
    {
	return self::anchorIcon("pencil.png", $text, $href, "", $title, $id);
    }
    
    /**
     * @param string $text
     * @param string $href
     * @param string $title
     * @param string $id
     * @return string
     */
    public static function addIcon($text, $href, $title = "", $id = "")
    {
	return self::anchorIcon("add.png", $text, $href, "", $title, $id);
    }
    
    /**
     * @param string $text
     * @param string $href
     * @param string $title
     * @param string $id
     * @return string
     */
    public static function manageIcon($text, $href, $title = "", $id = "")
    {
	return self::anchorIcon("text_list_bullets.png", $text, $href, "", $title, $id);
    }
    
    /**
     * @param string $text
     * @param string $href
     * @param string $title
     * @param string $id
     * @return string
     */
    public static function trashIcon($text, $href, $confirm = true, $title = "", $id = "")
    {
	return self::anchorIcon(
		"bin_empty.png", 
		$text, 
		$href, 
		"", 
		$title, 
		$id, 
		$confirm ? "if(!confirm('Are you sure you want to trash this?'))return false;" : ""
	    );
    }
    
    /**
     * @param string $text
     * @param string $href
     * @param string $title
     * @param string $id
     * @return string
     */
    public static function viewIcon($text, $href, $title = "", $id = "")
    {
	return self::anchorIcon("bullet_go.png", $text, $href, "", $title, $id);
    }
    
    /**
     * 
     * @param string $text
     * @param string $href
     * @param bool $confirm
     * @param string $title
     * @param string $id
     */
    public static function deleteIcon($text, $href, $confirm = true, $title = "", $id = "")
    {
	return self::anchorIcon(
		"delete.png", 
		$text, 
		$href, 
		"", 
		$title, 
		$id, 
		$confirm ? "if(!confirm('Are you sure you want to delete this?'))return false;" : ""
	    );
    }
    
    /**
     * @param string $text
     * @param string $href
     * @return string
     */
    public static function backAnchorIcon($text, $href)
    {
	return self::anchorIcon("arrow_left.png", $text, $href,"", "back");
    }
}
