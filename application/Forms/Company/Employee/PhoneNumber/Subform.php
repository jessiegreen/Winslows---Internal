<?php
namespace Forms\Company\Employee\PhoneNumber;

class Subform extends \Forms\PhoneNumber\Subform
{    
    protected $_PhoneNumber;
    
    public function __construct(\Entities\Company\Employee\PhoneNumber $PhoneNumber, $options = null)
    {
	$this->_PhoneNumber = $PhoneNumber;
	
	parent::__construct($options, $this->_PhoneNumber);
    }
    
    public function init($options = array())
    {
	$this->addElement(new \Dataservice_Form_Element_Company_Employee_Select("employee_id", array(
            'required'	    => true,
            'label'	    => 'employee:',
	    'belongsTo'	    => 'company_employee_phone_number',
	    'value'	    => $this->_PhoneNumber && $this->_PhoneNumber->getEmployee() ? $this->_PhoneNumber->getEmployee()->getId() : ""
        )));
	
	parent::init($options);
    }
}
