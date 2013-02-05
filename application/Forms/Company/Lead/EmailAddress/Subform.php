<?php
namespace Forms\Company\Lead\EmailAddress;

class Subform extends \Forms\Company\EmailAddress\Subform
{    
    protected $_EmailAddress;
    
    public function __construct(\Entities\Company\Lead\EmailAddress $EmailAddress, $options = null)
    {
	$this->_EmailAddress = $EmailAddress;
	
	parent::__construct($this->_EmailAddress, $options);
    }
    
    public function init($options = array())
    {
	$this->addElement('hidden', 'lead_id', array(
            'required'	    => true,
            'label'	    => '',
	    'value'	    => $this->_EmailAddress && $this->_EmailAddress->getLead() ? $this->_EmailAddress->getLead()->getId() : ""
        ));
	
	parent::init($options);
	
	$this->setElementsBelongTo("company_lead_email_address");
    }
}
