<?php
namespace Forms\Company\Location;

class PhoneNumber extends \Dataservice_Form
{    
    private $_PhoneNumber;
    
    public function __construct(\Entities\Company\Location\PhoneNumber $PhoneNumber, $options = null)
    {
	$this->_PhoneNumber = $PhoneNumber;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new PhoneNumber\Subform($this->_PhoneNumber, $options);
	
	$this->addSubForm($form, "company_location_phone_number");
	
	$this->addElement('submit', 'submit', array(
            'ignore'	    => true,
        ));
    }
}