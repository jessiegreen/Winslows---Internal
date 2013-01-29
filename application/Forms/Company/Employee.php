<?php
namespace Forms\Company;

class Employee extends \Zend_Form
{    
    private $_Employee;
    
    public function __construct($options = null, \Entities\Company\Employee $Employee = null) 
    {
	$this->_Employee = $Employee;
	
	parent::__construct($options, $this->_Employee);
    }
    
    public function init($options = array())
    {	
	$form = new Employee\Subform($options, $this->_Employee);
	
        $this->addSubForm($form, "company_employee");

        $this->addElement('submit', 'submit', array(
            'ignore'	    => true,
        ));
    }
}