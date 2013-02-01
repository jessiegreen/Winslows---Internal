<?php
namespace Forms\Company;

class Employee extends \Dataservice_Form
{    
    private $_Employee;
    
    public function __construct(\Entities\Company\Employee $Employee, $options = null) 
    {
	$this->_Employee = $Employee;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
	$form = new Employee\Subform($this->_Employee, $options);
	
        $this->addSubForm($form, "company_employee");

        $this->addElement('submit', 'submit', array(
            'ignore'	    => true,
        ));
    }
}