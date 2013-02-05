<?php
namespace Forms\Company\Employee\Address;

class Subform extends \Forms\Company\Address\Subform
{    
    protected $_Address;
    
    public function __construct(\Entities\Company\Employee\Address $Address, $options = null)
    {
	$this->_Address = $Address;
	
	parent::__construct($this->_Address, $options);
    }
    
    public function init($options = array())
    {
	$this->addElement(new \Dataservice_Form_Element_Company_Employee_Select("employee_id", array(
            'required'	    => true,
            'label'	    => 'Employee:',
	    'value'	    => $this->_Address && $this->_Address->getEmployee() ? $this->_Address->getEmployee()->getId() : ""
        )));
	
	parent::init($options);
	
	$this->setElementsBelongTo('company_employee_address');
    }
}
