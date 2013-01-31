<?php
namespace Forms\Company\Location;

class Subform extends \Forms\Company\Location\Subform
{
    private $_Location;
    
    public function __construct($options = null, \Entities\Company\Location $Location = null)
    {
	$this->_Location = $Location;
	
	parent::__construct($options, $Location);
    }
    
    public function init()
    {	
	$this->addElement(new \Dataservice_Form_Element_CompanySelect("company_id", array(
            'required'	    => true,
            'label'	    => 'Company:',
	    'belongsTo'	    => 'company_location',
	    'value'	    => $this->_Location && $this->_Location->getCompany() ? 
				$this->_Location->getCompany()->getId() : 
				""
        )));
	
	parent::init();
    }
}