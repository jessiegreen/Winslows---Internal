<?php
namespace Dataservice\Html\Menu;

class SuperFish 
{
    private static $_icon_url = "/img/icons/";

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
    
    private static function superFish_icon($data_array, $float_left = true)
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