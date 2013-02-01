<?php
namespace Forms\Company\RtoProvider\Fee;

class Subform extends \Zend_Form_SubForm
{
    private $_Fee;
    
    public function __construct(\Entities\Company\RtoProvider\Fee\FeeAbstract $Fee, $options = null)
    {
	$this->_Fee = $Fee;
	
	parent::__construct($options);
    }
    
    public function init()
    {
	$this->addElement(new \Dataservice_Form_Element_Company_RtoProviderSelect("rto_provider_id", array(
            'required'	    => true,
            'label'	    => 'RtoProvider:',
	    'value'	    => $this->_Fee && $this->_Fee->getRtoProvider() ? $this->_Fee->getRtoProvider()->getId() : ""
        )));
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'value'	    => $this->_Fee ? $this->_Fee->getName() : ""
        ));
	
	$this->addElement('text', 'name_index', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'value'	    => $this->_Fee ? $this->_Fee->getNameIndex() : ""
        ));
	
	$this->setElementsBelongTo("company_rto_provider_fee");
    }
}
