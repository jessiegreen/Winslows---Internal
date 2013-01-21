<?php

/**
 * ProfileLink helper
 *
 * Call as $this->profileLink() in your layout script
 */
class Dataservice_View_Helper_CRUD_Tabs  extends Zend_View_Helper_Abstract
{
    public function CRUD_Tabs()
    {
	return $this;
    }
    
    public function headers($tabs)
    {
	?>
	<ul>
	    <?php
	    foreach($tabs as $tab)
	    {
		?>
	    <li><a href="#<?php echo str_ireplace(" ", "_", $tab);?>"><?php echo $tab;?></a></li>
		<?php
	    }
	    ?>
	</ul>
	<?php
    }
}