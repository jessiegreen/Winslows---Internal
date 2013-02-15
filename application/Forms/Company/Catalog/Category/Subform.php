<?php
namespace Forms\Company\Catalog\Category;

class Subform extends \Zend_Form_SubForm
{
    private $_Category;
    
    public function __construct(\Entities\Company\Catalog\Category $Category, $options = null)
    {
	$this->_Category = $Category;
	
	parent::__construct($options);
    }
    
    public function init()
    {		
	$this->addElement(new \Dataservice_Form_Element_Company_Catalog_Category_Select(
	    $this->_Category,
	    "parent_id", 
	    array(
		'required'	=> false,
		'label'		=> 'Parent:',
		'description'   => 'Leave blank if no parent',
		'value'		=> $this->_Category && $this->_Category->getParent() ? 
				    $this->_Category->getParent()->getId() : 
				    ""
	    )));
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'value'	    => $this->_Category ? $this->_Category->getName() : ""
        ));
	
	$this->addElement('text', 'index_string', array(
            'required'	    => true,
            'label'	    => 'Index:',
	    'value'	    => $this->_Category ? $this->_Category->getIndex() : ""
        ));
	
	$this->addElement('text', 'sort_order', array(
            'required'	    => false,
            'label'	    => 'Order:',
	    'value'	    => $this->_Category ? $this->_Category->getSortOrder() : ""
        ));
	
	$this->setElementsBelongTo("company_catalog_category");
    }
}