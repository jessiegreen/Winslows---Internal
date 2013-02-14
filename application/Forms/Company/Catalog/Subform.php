<?php
namespace Forms\Company\Catalog;

class Subform extends \Zend_Form_SubForm
{
    private $_Catalog;
    
    public function __construct( \Entities\Company\Catalog $Catalog, $options = null)
    {
	$this->_Catalog = $Catalog;
	
	parent::__construct($options);
    }
    
    public function init()
    {	
	$this->addElement('hidden', 'company_id', array(
            'required'	    => false,
            'label'	    => '',
	    'value'	    => $this->_Catalog && $this->_Catalog->getCompany() ? $this->_Catalog->getCompany()->getId() : ""
        ));
	
	$this->addElement('text', 'name', array(
            'required'	    => false,
            'label'	    => 'Name:',
	    'value'	    => $this->_Catalog ? $this->_Catalog->getName() : ""
        ));
	
	$this->addElement('text', 'name_index', array(
            'required'	    => false,
            'label'	    => 'Name Index:',
	    'value'	    => $this->_Catalog ? $this->_Catalog->getNameIndex() : ""
        ));
	
	$this->setElementsBelongTo("company_catalog");
    }
}