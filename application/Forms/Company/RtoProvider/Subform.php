<?php
namespace Forms\Company\RtoProvider;

class Subform extends \Zend_Form_SubForm
{
    private $_RtoProvider;
    
    public function __construct(\Entities\Company\RtoProvider $RtoProvider, $options = null)
    {
	$this->_RtoProvider = $RtoProvider;
	
	parent::__construct($options);
    }
    
    public function init()
    {		
	$this->addElement(new \Dataservice_Form_Element_CompanySelect("company_id", array(
            'required'	    => true,
            'label'	    => 'Company:',
	    'value'	    => $this->_RtoProvider && $this->_RtoProvider->getCompany() ? $this->_RtoProvider->getCompany()->getId() : ""
        )));
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'value'	    => $this->_RtoProvider ? $this->_RtoProvider->getName() : ""
        ));
	
	$this->addElement('text', 'dba', array(
            'required'	    => true,
            'label'	    => 'DBA:',
	    'value'	    => $this->_RtoProvider ? $this->_RtoProvider->getDba() : ""
        ));
	
	$this->addElement('text', 'name_index', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'value'	    => $this->_RtoProvider ? $this->_RtoProvider->getNameIndex() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'rows'	    => '10',
	    'cols'	    => '35',
	    'value'	    => $this->_RtoProvider ? $this->_RtoProvider->getDescription() : ""
        ));
	
	$this->setElementsBelongTo("company_rto_provider");
    }
}