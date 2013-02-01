<?php
namespace Forms\Company;

class Location extends \Zend_Form
{    
    private $_Location;
    
    public function __construct($options = null, \Entities\Company\Location $Location = null)
    {
	$this->_Location = $Location;
	
	parent::__construct($options, $this->_Location);
    }
    
    public function init($options = array())
    {	
        $form = new Location\Subform($options, $this->_Location);
	
	$this->addSubForm($form, "company_location");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}