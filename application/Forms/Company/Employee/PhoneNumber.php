<?php
namespace Forms\Company\Employee;

class PhoneNumber extends \Dataservice_Form
{    
    private $_PhoneNumber;
    
    public function __construct(\Entities\Company\Employee\PhoneNumber $PhoneNumber, $options = null)
    {
	$this->_PhoneNumber = $PhoneNumber;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new PhoneNumber\Subform($this->_PhoneNumber, $options);
	
	$this->addSubForm($form, "company_employee_phone_number");
	
	$this->addElement('submit', 'submit', array(
            'ignore'	    => true,
        ));
    }
}