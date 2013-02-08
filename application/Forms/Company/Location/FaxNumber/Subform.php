<?php
namespace Forms\Company\Location\FaxNumber;

class Subform extends \Forms\Company\FaxNumber\Subform
{
    private $_FaxNumber;
    
    public function __construct(\Entities\Company\Location\FaxNumber $FaxNumber, $options = null)
    {
	$this->_FaxNumber = $FaxNumber;
	
	parent::__construct($this->_FaxNumber, $options);
    }
    
    public function init()
    {
	$this->addElement('hidden', 'location_id', array(
            'required'	    => true,
            'label'	    => '',
	    'value'	    => $this->_FaxNumber && $this->_FaxNumber->getLocation() ? $this->_FaxNumber->getLocation()->getId() : ""
        ));
	
	parent::init();
    }
}