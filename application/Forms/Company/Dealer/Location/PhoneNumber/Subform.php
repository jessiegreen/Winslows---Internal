<?php
namespace Forms\Company\Dealer\Location\PhoneNumber;

class Subform extends \Forms\Company\PhoneNumber\Subform
{
    private $_PhoneNumber;
    
    public function __construct(\Entities\Company\Location\PhoneNumber $PhoneNumber, $options = null)
    {
	$this->_PhoneNumber = $PhoneNumber;
	
	parent::__construct($options, $this->_PhoneNumber);
    }
    
    public function init($options = array())
    {
	$this->addElement(new \Dataservice_Form_Element_Company_Dealer_LocationSelect("location_id", array(
            'required'	    => true,
            'label'	    => 'Location:',
	    'value'	    => $this->_PhoneNumber && $this->_PhoneNumber->getLocation() ? 
				$this->_PhoneNumber->getLocation()->getId() : 
				""
        )));
	
	parent::init($options);
	
	$this->setElementsBelongTo('company_dealer_location_phonenumber');
    }
}