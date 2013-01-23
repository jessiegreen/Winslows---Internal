<?php
class Dataservice_View_Helper_CRUD_Nav
{
    public function CRUD_Nav($text, $href)
    {
	echo "<div>";
	echo \Dataservice\Html\Anchor::backAnchorIcon($text, $href);
	echo "</div>";
    }
}