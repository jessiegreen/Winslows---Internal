<?php
namespace Forms\Company\Lead\Address;

class Subform extends \Forms\Company\Address\Subform
{    
    protected $_Address;
    
    public function __construct(\Entities\Company\Lead\Address $Address, $options = null)
    {
	$this->_Address = $Address;
	
	parent::__construct($options, $this->_Address);
    }
    
    public function init($options = array())
    {
	$this->addElement('hidden', 'lead_id', array(
            'required'	    => true,
            'label'	    => '',
	    'belongsTo'	    => "company_lead_address",
	    'value'	    => $this->_Address && $this->_Address->getLead() ? $this->_Address->getLead()->getId() : ""
        ));
	
	parent::init($options);
    }
}
