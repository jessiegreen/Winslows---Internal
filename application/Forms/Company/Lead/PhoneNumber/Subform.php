<?php
namespace Forms\Company\Lead\PhoneNumber;

class Subform extends \Forms\Company\PhoneNumber\Subform
{    
    protected $_PhoneNumber;
    
    public function __construct(\Entities\Company\Lead\PhoneNumber $PhoneNumber, $options = null)
    {
	$this->_PhoneNumber = $PhoneNumber;
	
	parent::__construct($this->_PhoneNumber, $options);
    }
    
    public function init($options = array())
    {
	$this->addElement('hidden', 'lead_id', array(
            'required'	    => true,
            'label'	    => '',
	    'value'	    => $this->_PhoneNumber && $this->_PhoneNumber->getLead() ? $this->_PhoneNumber->getLead()->getId() : ""
        ));
	
	parent::init($options);
	
	$this->setElementsBelongTo("company_lead_phone_number");
    }
}
