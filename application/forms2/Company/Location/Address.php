<?php
namespace Forms\Company\Location;

class Address extends \Zend_Form
{    
    private $_Address;
    
    public function __construct($options = null, \Entities\Company\Location\Address $Address = null)
    {
	$this->_Address = $Address;
	
	parent::__construct($options, $this->_Address);
    }
    
    public function init($options = array())
    {
	$form = new Address\Subform($options, $this->_Address);
	
	$this->addSubForm($form, "company_location_address");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}