<?php
namespace Forms\Company\Location\Address;

class Subform extends \Forms\Company\Address\Subform
{    
    private $_Address;
    
    public function __construct(\Entities\Company\Location\Address $Address, $options = null)
    {
	$this->_Address = $Address;
	
	parent::__construct($this->_Address, $options);
    }
    
    public function init($options = array())
    {
	$this->addElement('hidden', 'location_id', array(
            'required'	    => true,
            'label'	    => '',
	    'value'	    => $this->_Address && $this->_Address->getLocation() ? $this->_Address->getLocation()->getId() : ""
        ));
	
	parent::init($options);
    }
}