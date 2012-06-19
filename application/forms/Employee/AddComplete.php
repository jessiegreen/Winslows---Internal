<?php

/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */

class Form_Employee_AddComplete extends Form_Person_AddComplete
{
    public function init($options = array())
    {
        $form1 = new Form_Employee_Employee;
	unset($form1->submit);
        $this->addElements($form1->getElements());
	
	$this->addDisplayGroup(array(
                    'title',    
            ),'employee',array('legend' => 'Employment'));
	
	parent::init($options);
    }
}


?>
