<?php
namespace Forms\Company\Location;

class FaxNumber extends \Dataservice_Form
{    
    private $_FaxNumber;
    
    public function __construct(\Entities\Company\Location\FaxNumber $FaxNumber, $options = null)
    {
	$this->_FaxNumber = $FaxNumber;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new FaxNumber\Subform($this->_FaxNumber, $options);
	
	$this->addSubForm($form, "company_location_fax_number");
	
	$this->addElement('submit', 'submit', array(
            'ignore'	    => true,
        ));
    }
}