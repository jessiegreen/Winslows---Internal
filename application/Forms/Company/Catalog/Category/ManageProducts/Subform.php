<?php
namespace Forms\Company\Catalog\Category\ManageProducts;

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
	$values = array();
	
	if($this->_Category)
	{
	    foreach($this->_Category->getProducts() as $Product)
	    {
		$values[] = $Product->getId();
	    }
	}
	
	$this->addElement(new \Dataservice_Form_Element_Company_Catalog_Product_MultiCheckbox(
	    $this->_Category->getCatalog(),
	    "products", 
	    array(
		'required'	    => false,
		'label'	    => 'Products:',
		'value'	    => $values
	    )));
	
	$this->setElementsBelongTo("company_catalog_category_manage_products");
    }
}