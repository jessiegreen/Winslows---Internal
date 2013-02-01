<?php
namespace Forms\Company\Employee\Account;

class Subform extends \Forms\Company\Website\Account\Subform
{    
    private $_Account;
    
    private $_safe;
    
    public function __construct(\Entities\Company\Employee\Account  $Account, $options = null,  $safe = true) 
    {
	$this->_Account = $Account;
	$this->_safe	= $safe;
        
	parent::__construct($this->_Account, $options, $this->_safe);
    }
    
    public function init($options = array())
    {	
	$this->addElement(new \Dataservice_Form_Element_EmployeeSelect("employee_id", array(
            'required'	    => true,
            'label'	    => 'Employee:',
	    'value'	    => $this->_Account && $this->_Account->getEmployee() ? $this->_Account->getEmployee()->getId() : ""
        )));
        
	parent::init($options);
	
	$this->setElementsBelongTo("company_employee_account");
    }
}