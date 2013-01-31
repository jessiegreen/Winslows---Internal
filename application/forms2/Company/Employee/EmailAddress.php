<?php
namespace Forms\Company\Employee;

class EmailAddress extends \Dataservice_Form
{    
    private $_EmailAddress;
    
    public function __construct(\Entities\Company\Employee\EmailAddress $EmailAddress, $options = null)
    {
	$this->_EmailAddress = $EmailAddress;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new EmailAddress\Subform($this->_EmailAddress, $options);
	
	$this->addSubForm($form, "company_employee_email_address");
	
	$this->addElement('submit', 'submit', array(
            'ignore'	    => true,
        ));
    }
}