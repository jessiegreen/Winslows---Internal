<?php
namespace Forms\Company\Lead\FaxNumber;

class Subform extends \Forms\Company\FaxNumber\Subform
{    
    protected $_FaxNumber;
    
    public function __construct(\Entities\Company\Lead\FaxNumber $FaxNumber, $options = null)
    {
	$this->_FaxNumber = $FaxNumber;
	
	parent::__construct($options, $this->_FaxNumber);
    }
    
    public function init($options = array())
    {
	$this->addElement('hidden', 'lead_id', array(
            'required'	    => true,
            'label'	    => '',
	    'value'	    => $this->_FaxNumber && $this->_FaxNumber->getLead() ? $this->_FaxNumber->getLead()->getId() : ""
        ));
	
	parent::init($options);
	
	$this->setElementsBelongTo("company_lead_fax_number");
    }
}
