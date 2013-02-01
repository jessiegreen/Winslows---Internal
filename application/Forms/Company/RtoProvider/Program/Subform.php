<?php
namespace Forms\Company\RtoProvider\Program;

class Subform extends \Zend_Form_SubForm
{
    private $_Program;
    
    public function __construct(\Entities\Company\RtoProvider\Program $Program, $options = null)
    {
	$this->_Program = $Program;
	
	parent::__construct($options);
    }
    
    public function init()
    {
	$this->addElement(new \Dataservice_Form_Element_Company_RtoProviderSelect("rto_provider_id", array(
            'required'	    => true,
            'label'	    => 'RtoProvider:',
	    'value'	    => $this->_Program && $this->_Program->getRtoProvider() ? $this->_Program->getRtoProvider()->getId() : ""
        )));
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'value'	    => $this->_Program ? $this->_Program->getName() : ""
        ));
	
	$this->addElement('text', 'name_index', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'value'	    => $this->_Program ? $this->_Program->getNameIndex() : ""
        ));
	
	$this->addElement('text', 'payment_count', array(
            'required'	    => true,
            'label'	    => 'Payment Count:',
	    'value'	    => $this->_Program ? $this->_Program->getPaymentCount() : ""
        ));
	
	$this->addElement('text', 'factor', array(
            'required'	    => true,
            'label'	    => 'Payment Factor:',
	    'value'	    => $this->_Program ? $this->_Program->getFactor() : ""
        ));
	
	$this->setElementsBelongTo("company_rto_provider_program");
    }
}
