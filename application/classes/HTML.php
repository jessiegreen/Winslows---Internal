<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HTML
 *
 * @author Jessie
 */
class HTML 
{
    private static $_icon_url = "/img/icons/";
    
    public static function blue_ribbon($content) {
	?>
	<table style="clear: both;width:100%;table-layout: fixed;" cellspacing="0" cellpadding="0">
	    <td style="width:34px;height: 42px;background-image: url('<?php echo BASE_URL;?>/img/ribbon_left.png')">&nbsp</td>
	    <td style="height: 42px;background-image: url('<?php echo BASE_URL;?>/img/ribbon_center.png');text-align: center;width: 100%;">
		<div style="color:#FFF;font-weight: 500;font-size: 18px;padding-top: 4px;letter-spacing: 2px;width: 100%"><?php echo htmlspecialchars($content);?></div>
	    </td>
	    <td style="width:34px;height: 42px;background-image: url('<?php echo BASE_URL;?>/img/ribbon_right.png')">&nbsp;</td>
	</table>
	<?php
    }
    
    public static function down_arrow(){
	?>
	<img src="<?php echo BASE_URL;?>/img/home/down_arrow.png" style="height: 12px;"/>
	<?php
    }
    
    public static function superFish_menu($menu_array){
	?>
	<ul class="sf-menu">
	    <?php
		foreach($menu_array as $menu_item){
		    echo '<li class="current">';
		    if(isset($menu_item['label'])){
			echo '<a '.(isset($menu_item['url']) ? 'href="'.$menu_item['url'].'"' : '').'>'.self::superFish_icon($menu_item).' '.$menu_item['label'].'</a>';
			if(isset($menu_item['subs'])){
			    echo '<ul>';
			    foreach($menu_item['subs'] as $sub){
				echo'<li><a href="'.$sub['url'].'">'.self::superFish_icon($sub).' '.$sub['label'].'</a>';
				if(isset($sub['subs'])){
				    echo '<ul>';
				    foreach($sub['subs'] as $sub2){
					echo'<li><a href="'.$sub2['url'].'">'.self::superFish_icon($sub2).' '.$sub2['label'].'</a></li>';
				    }
				    echo '</ul>';
				}
				echo '</li>';
			    }
			    echo '</ul>';
			}
		    }
		    echo '</li>';
		}
	    ?>
	</ul>
	<?php
    }
    
    private static function superFish_icon($data_array, $float_left = true){
	if(isset($data_array['icon'])){
	    $icon_url = self::$_icon_url.$data_array['icon'];
	    if(file_exists(PUBLIC_PATH.$icon_url)){
		return '<img src="'.$icon_url.'" style="'.($float_left ? 'float:left;' : '').'margin-right:5px;vertical-align:bottom;" />';
	    }
	    else return '';
	}
    }
    
    public static function buttonBlue($icon, $text, $id = "", $style = "", $class = "", $attr="") {
	return "<div class='button_blue $class' id='$id' style='$style' ".$attr.">".self::superFish_icon(array("icon" => $icon), false)." $text</div>";
    }
    
    public static function buttonIcon($icon, $id = "", $title = "", $class = "", $style = "", $attr="") {
	return '<img src="/img/icons/'.$icon.'" class="button_icon '.$class.'" style="'.$style.'" id="'.$id.'" title="'.$title.'" '.$attr.'/>';
    }
    
    public static function anchorIcon($icon, $text, $href, $style = "", $title = "", $id = ""){
	return '<a href="'.$href.'" title="'.$title.'" style="border:none;'.$style.'" id="'.$id.'">'.
		    '<img src="'.self::$_icon_url.'/'.$icon.'"/ style="margin-right:5px;vertical-align:bottom;">'.
		    $text.
		'</a>';
    }
    
    public static function backAnchorIcon($text, $href){
	return self::anchorIcon("arrow_left.png", $text, $href,"", "back");
    }
    
    /**
     *
     * @param string $string
     * @param int $length
     * @return string 
     */
    public static function truncateString($string, $length){
	if(is_string($string) && is_numeric($length)){
	    return strlen($string) > $length ? substr($string, 0, $length)."..." : $string;
	}
	else return "";
    }
}

?>
