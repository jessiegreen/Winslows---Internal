<?php

/**
 * ProfileLink helper
 *
 * Call as $this->profileLink() in your layout script
 */
class Dataservice_View_Helper_Maintenance_Menuitem//  extends Zend_View_Helper_Abstract
{
    public $view;

    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }

    public function Maintenance_Menuitem(\Entities\Website\Menu\Item $MenuItem)
    {
        $this->render($MenuItem);
	$children = $MenuItem->getChildren();
	if($children){
	    ?>
	    <ol>
		<?php
		foreach($children as $MenuItem2)
		{
		    $this->Maintenance_Menuitem($MenuItem2);
		}
		?>
	    </ol>
	    <?php
	}
    }
    
    private function render(\Entities\Website\Menu\Item $MenuItem){
	?>
	<li menuitem_id="<?php echo $MenuItem->getId();?>"> 
	    <?php 
	    //HTML::buttonIcon($icon, $id, $title, $class, $style)
	    echo HTML::buttonIcon("bullet_wrench.png", "menuitem_edit", "Edit Menu Item Details", "menuitem_edit", "padding-right:3px;");
	    echo HTML::buttonIcon("bullet_add.png", "child_add", "Add Sub to Menu Item", "child_add", "padding-right:3px;");
	    echo HTML::buttonIcon("bullet_delete.png", "menuitem_remove", "Remove Menu Item", "menuitem_remove", "padding-right:3px;");
	    echo $MenuItem->getLabel();
	    ?>
	</li>
	<?php
    }
}

?>
