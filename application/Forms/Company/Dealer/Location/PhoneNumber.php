<?php
namespace Forms\Company\Dealer\Location;

class PhoneNumber extends \Dataservice_Form
{    
    private $_PhoneNumber;
    
    public function __construct(\Entities\Company\Dealer\Location\PhoneNumber $PhoneNumber, $options = null)
    {
	$this->_PhoneNumber = $PhoneNumber;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new PhoneNumber\Subform($this->_PhoneNumber, $options);
	
	$this->addSubForm($form, "company_dealer_location_phonenumber");
	
	$this->addElement('submit', 'submit', array(
            'ignore'	    => true,
        ));
    }
}