<?php
namespace Forms\Company\Dealer\Location\Address;

class Subform extends \Forms\Company\Address\Subform
{    
    private $_Address;
    
    public function __construct(\Entities\Company\Location\Address $Address, $options = null)
    {
	$this->_Address = $Address;
	
	parent::__construct($options, $this->_Address);
    }
    
    public function init($options = array())
    {
	$this->addElement(new \Dataservice_Form_Element_Company_Dealer_LocationSelect("location_id", array(
            'required'	    => true,
            'label'	    => 'Location:',
	    'value'	    => $this->_Address && $this->_Address->getLocation() ? 
				$this->_Address->getLocation()->getId() : 
				""
        )));
	
	parent::init($options);
	
	$this->setElementsBelongTo('company_dealer_location_address');
    }
}