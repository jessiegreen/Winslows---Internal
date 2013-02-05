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
	return '<a href="'.$href.'" title="'.$title.'" style="border:none;'.$style.'" id="'.$id.'" onclick="'.$onclick.'">'.
		    '<img src="'.self::$_icon_url.'/'.$icon.'"/ style="margin-right:5px;margin-left:5px;vertical-align:bottom;">'.
		    $text.
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
