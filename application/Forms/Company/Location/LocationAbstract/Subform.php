<?php
namespace Forms\Company\Location\LocationAbstract;

class Subform extends \Zend_Form_SubForm
{
    private $_Location;
    
    public function __construct(\Entities\Company\Location\LocationAbstract $Location, $options = null)
    {
	$this->_Location = $Location;
	
	parent::__construct($options);
    }
    
    public function init()
    {	
	if($this->_Location)
	{
	    $type_options   = $this->_Location->getTypeOptions();
	}
	else
	{
	    $Location	    = new \Entities\Company\Location\LocationAbstract();
	    $type_options   = $Location->getTypeOptions();
	}
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'value'	    => $this->_Location ? $this->_Location->getName() : ""
        ));
	
	$this->addElement('select', 'type', array(
            'required'	    => true,
            'label'	    => 'Type:',
	    'multioptions'  => $type_options,
	    'value'	    => $this->_Location ? $this->_Location->getType() : ""
        ));
	
	$this->setElementsBelongTo("company_location");
    }
}