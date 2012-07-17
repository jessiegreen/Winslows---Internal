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
    protected $_Employee;
    
    public function __construct($options = null, Entities\Employee $Employee = null) {
	$this->_Employee = $Employee;
	parent::__construct($options, $this->_Employee);
    }
    
    public function init($options = array())
    {
	parent::init($options, $this->_Employee);
	
        $form = new Form_Employee_Employee($options, $this->_Employee);
	$form->isArray(true);
	$form->removeElement("submit");
	$form->setLegend("Employee Info");
	$form->setDecorators(array(
	    "FormElements",
	    "Fieldset",
	    array("HtmlTag", array("tag" => "div"))
	));
	$form->setElementsBelongTo("form_employee");
        $this->addSubForm($form, "form_employee", 0);
	
	parent::removeSubForm("form_person");
    }
}


?>
