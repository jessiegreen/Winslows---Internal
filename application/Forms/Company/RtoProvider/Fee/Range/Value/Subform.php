<?php
namespace Forms\Company\RtoProvider\Fee\Range\Value;

class Subform extends \Zend_Form_SubForm
{
    private $_Value;
    
    public function __construct(\Entities\Company\RtoProvider\Fee\Range\Value $Value, $options = null)
    {
	$this->_Value = $Value;
	
	parent::__construct($options);
    }
    
    public function init()
    {	
	$this->addElement(new \Dataservice_Form_Element_Company_RtoProvider_Fee_RangeSelect("range_id", array(
            'required'	    => true,
            'label'	    => 'Range:',
	    'value'	    => $this->_Value && $this->_Value->getRange() ? $this->_Value->getRange()->getId() : ""
        )));
	
	$this->addElement('text', 'value', array(
            'required'	    => true,
            'label'	    => 'Value:',
	    'value'	    => $this->_Value ? $this->_Value->getValue() : ""
        ));
	
	$this->addElement('text', 'low', array(
            'required'	    => true,
            'label'	    => 'Low:',
	    'value'	    => $this->_Value ? $this->_Value->getLow() : ""
        ));
	
	$this->addElement('text', 'high', array(
            'required'	    => true,
            'label'	    => 'High:',
	    'value'	    => $this->_Value ? $this->_Value->getHigh() : ""
        ));
	
	$this->setElementsBelongTo('company_rto_provider_fee_range_value');
    }
}
