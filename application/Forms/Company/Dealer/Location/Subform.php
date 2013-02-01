<?php
namespace Forms\Company\Dealer\Location;

class Subform extends \Forms\Company\Location\Subform
{
    private $_Location;
    
    public function __construct(\Entities\Company\Dealer\Location $Location, $options = null)
    {
	$this->_Location = $Location;
	
	parent::__construct($options, $Location);
    }
    
    public function init()
    {
	$this->addElement(new \Dataservice_Form_Element_Company_DealerSelect("dealer_id", array(
            'required'	    => true,
            'label'	    => 'Dealer:',
	    'value'	    => $this->_Location && $this->_Location->getDealer() ? 
				$this->_Location->getDealer()->getId() : 
				""
        )));
	
	parent::init();
	
	$this->setElementsBelongTo('company_dealer_location');
    }
}