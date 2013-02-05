<?php
namespace Forms\Company\Employee\EmailAddress;

class Subform extends \Forms\Company\EmailAddress\Subform
{    
    protected $_EmailAddress;
    
    public function __construct(\Entities\Company\Employee\EmailAddress $EmailAddress, $options = null)
    {
	$this->_EmailAddress = $EmailAddress;
	
	parent::__construct($this->_EmailAddress, $options);
    }
    
    public function init($options = array())
    {
	$this->addElement(new \Dataservice_Form_Element_Company_Employee_Select("employee_id", array(
            'required'	    => true,
            'label'	    => 'Employee:',
	    'value'	    => $this->_EmailAddress && $this->_EmailAddress->getEmployee() ? $this->_EmailAddress->getEmployee()->getId() : ""
        )));
	
	parent::init($options);
	
	$this->setElementsBelongTo('company_employee_email_address');
    }
}
