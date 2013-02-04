<?php
namespace Forms\Company\Dealer\Location\FaxNumber;

class Subform extends \Forms\Company\FaxNumber\Subform
{
    private $_FaxNumber;
    
    public function __construct(\Entities\Company\Dealer\Location\FaxNumber $FaxNumber, $options = null)
    {
	$this->_FaxNumber = $FaxNumber;
	
	parent::__construct($this->_FaxNumber, $options);
    }
    
    public function init($options = array())
    {
	$this->addElement(new \Dataservice_Form_Element_Company_Dealer_LocationSelect("location_id", array(
            'required'	    => true,
            'label'	    => 'Location:',
	    'value'	    => $this->_FaxNumber && $this->_FaxNumber->getLocation() ? 
				$this->_FaxNumber->getLocation()->getId() : 
				""
        )));
	
	parent::init($options);
	
	$this->setElementsBelongTo('company_dealer_location_fax_number');
    }
}