<?php
namespace Forms\Company\Dealer\Location;

class Address extends \Dataservice_Form
{    
    private $_Address;
    
    public function __construct(\Entities\Company\Location\Address $Address, $options = null)
    {
	$this->_Address = $Address;
	
	parent::__construct($options, $this->_Address);
    }
    
    public function init($options = array())
    {
	$form = new Address\Subform($this->_Address, $options);
	
	$this->addSubForm($form, "company_dealer_location_address");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}