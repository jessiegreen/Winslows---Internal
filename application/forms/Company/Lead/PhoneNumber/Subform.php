<?php
namespace Forms\Company\Lead\PhoneNumber;

class Subform extends \Forms\Company\PhoneNumber\Subform
{    
    protected $_PhoneNumber;
    
    public function __construct(\Entities\Company\Lead\PhoneNumber $PhoneNumber, $options = null)
    {
	$this->_PhoneNumber = $PhoneNumber;
	
	parent::__construct($options, $this->_PhoneNumber);
    }
    
    public function init($options = array())
    {
	$this->addElement('hidden', 'lead_id', array(
            'required'	    => true,
            'label'	    => '',
	    'belongsTo'	    => "company_lead_phone_number",
	    'value'	    => $this->_PhoneNumber && $this->_PhoneNumber->getLead() ? $this->_PhoneNumber->getLead()->getId() : ""
        ));
	
	parent::init($options);
    }
}
