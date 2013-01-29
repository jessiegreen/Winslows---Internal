<?php
class Dataservice_View_Helper_Maintenance_Menuitem//  extends Zend_View_Helper_Abstract
{
    public $view;

    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }

    public function Maintenance_Menuitem(\Entities\Company\Website\Menu\Item $MenuItem, $parent = false)
    {
        $this->render($MenuItem, $parent);
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
    
    private function render(\Entities\Company\Website\Menu\Item $MenuItem, $parent = false)
    {
	?>
	<li menuitem_id="<?php echo $MenuItem->getId();?>" style="padding: 4px;border:solid 1px silver;"> 
	    <?php 
	    //if($parent === false)echo "&rdsh;&nbsp;";
	    echo $MenuItem->getLabel();
	    //\Dataservice\Html\Button::buttonIcon($icon, $id, $title, $class, $style)
	    echo \Dataservice\Html\Button::buttonIcon("pencil.png", "menuitem_edit", "Edit Menu Item Details", "menuitem_edit", "padding-left:5px;width:10px;");
	    echo \Dataservice\Html\Button::buttonIcon("add.png", "child_add", "Add Sub to Menu Item", "child_add", "padding-left:3px;width:10px;");
	    echo \Dataservice\Html\Button::buttonIcon("delete.png", "menuitem_remove", "Remove Menu Item", "menuitem_remove", "padding-left:3px;width:10px;");
	    ?>
	</li>
	<?php
    }
}