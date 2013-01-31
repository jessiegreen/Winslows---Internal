<?php
namespace Forms\Company\Employee;

class FaxNumber extends \Dataservice_Form
{    
    private $_FaxNumber;
    
    public function __construct(\Entities\Company\Employee\FaxNumber $FaxNumber, $options = null)
    {
	$this->_FaxNumber = $FaxNumber;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new FaxNumber\Subform($this->_FaxNumber, $options);
	
	$this->addSubForm($form, "company_employee_fax_number");
	
	$this->addElement('submit', 'submit', array(
            'ignore'	    => true,
        ));
    }
}