<?php
namespace Forms\Company\Supplier\Product\Configurable\Option;

use Entities\Company\Supplier\Product\Configurable\Option as Option;

class Subform extends \Zend_Form_SubForm
{
    private $_Option;
    
    public function __construct($options = null, Option $Option = null)
    {
	$this->_Option = $Option;
	
	parent::__construct($options);
    }
    
    public function init()
    {
	$this->addElement(new \Dataservice_Form_Element_Company_Supplier_Product_Configurable_Option_CategorySelect("category_id", array(
		'label'		=> 'Category:',
		'required'	=> true,
		'value'		=> $this->_Option && $this->_Option->getCategory() && $this->_Option->getCategory()->getId()
				    ? $this->_Option->getCategory()->getId() 
				    : ""
	    )));
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'value'	    => $this->_Option ? $this->_Option->getName() : ""
        ));
	
	$this->addElement('text', 'index_string', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'value'	    => $this->_Option ? $this->_Option->getIndex() : ""
        ));
	
	$this->addElement('text', 'code', array(
            'required'	    => true,
	    'maxlength'	    => 2,
	    'size'	    => 2,
            'label'	    => 'Code:',
	    'value'	    => $this->_Option ? $this->_Option->getCode() : ""
        ));
	
	$this->addElement('text', 'maxcount', array(
            'required'	    => true,
	    'maxlength'	    => 4,
	    'size'	    => 4,
            'label'	    => 'Max Count:',
	    'value'	    => $this->_Option ? $this->_Option->getMaxCount() : "",
	    'validators'    => array("digits")
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'cols'	    => 50,
	    'rows'	    => 8,
	    'value'	    => $this->_Option ? $this->_Option->getDescription() : ""
        ));
	
	$this->addElement('select', 'required', array(
            'required'	    => true,
            'label'	    => 'Required:',
	    'multioptions'  => array(0 => "false", 1 => "true"),
	    'value'	    => $this->_Option ? $this->_Option->isRequired() : ""
        ));
	
	$this->setElementsBelongTo("company_supplier_product_configurable_option");
    }
}