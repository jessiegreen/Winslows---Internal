<?php
namespace Forms\Company;

class Location extends \Dataservice_Form
{    
    private $_Location;
    
    public function __construct(\Entities\Company\Location $Location, $options = null)
    {
	$this->_Location = $Location;
	
	parent::__construct($options, $this->_Location);
    }
    
    public function init($options = array())
    {	
        $form = new Location\Subform($this->_Location, $options);
	
	$this->addSubForm($form, "company_location");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}