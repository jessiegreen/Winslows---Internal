<?php
namespace Forms\Company;

class Subform extends \Zend_Form_SubForm
{
    private $_Company;
    
    public function __construct(\Entities\Company $Company, $options = null)
    {
	$this->_Company = $Company;
	
	parent::__construct($options);
    }
    
    public function init()
    {		
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'value'	    => $this->_Company ? $this->_Company->getName() : ""
        ));
	
	$this->addElement('text', 'dba', array(
            'required'	    => true,
            'label'	    => 'DBA:',
	    'value'	    => $this->_Company ? $this->_Company->getDba() : ""
        ));
	
	$this->addElement('text', 'name_index', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'value'	    => $this->_Company ? $this->_Company->getNameIndex() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'rows'	    => '10',
	    'cols'	    => '35',
	    'value'	    => $this->_Company ? $this->_Company->getDescription() : ""
        ));
	
	$this->setElementsBelongTo("company");
    }
}