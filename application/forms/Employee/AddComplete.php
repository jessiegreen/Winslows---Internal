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
    private $_Employee;
    
    public function __construct($options = null, Entities\Employee $Employee = null) {
	$this->_Employee = $Employee;
	parent::__construct($options, $this->_Employee);
    }
    
    public function init($options = array())
    {
        $form1 = new Form_Employee_Employee($options, $this->_Employee);
	unset($form1->submit);
        $this->addElements($form1->getElements());
	
	$this->addDisplayGroup(array('title'),'employee',array('legend' => 'Employment'));
	
	parent::init($options, $this->_Employee);
    }
}


?>
