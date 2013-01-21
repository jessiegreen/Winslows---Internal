<?php

/**
 * ProfileLink helper
 *
 * Call as $this->profileLink() in your layout script
 */
class Dataservice_View_Helper_CRUD_Header//  extends Zend_View_Helper_Abstract
{
    public function CRUD_Header($title)
    {
        ?>
	<h1 class="header1"><?php echo $title?></h1>
	<?php
    }
}