<?php
namespace Forms\Company\Lead;

class EmailAddress extends \Dataservice_Form
{    
    private $_EmailAddress;
    
    public function __construct(\Entities\Company\Lead\EmailAddress $EmailAddress, $options = null)
    {
	$this->_EmailAddress = $EmailAddress;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new EmailAddress\Subform($this->_EmailAddress, $options);
	
	$this->addSubForm($form, "company_lead_email_address");
	
	$this->addElement('submit', 'submit', array(
            'ignore'	    => true,
        ));
    }
}