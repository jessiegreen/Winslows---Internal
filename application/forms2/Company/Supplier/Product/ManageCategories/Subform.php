<?php
namespace Forms\Company\Supplier\Product\ManageCategories;

use Entities\Company\Supplier\Product\ProductAbstract as Product;

class Subform extends \Zend_Form_SubForm
{
    private $_Product;
    
    public function __construct(Product $Product, $options = null)
    {
	$this->_Product = $Product;
	
	parent::__construct($options);
    }
    
    public function init()
    {	
	$values = array();
	
	if($this->_Product)
	{
	    foreach($this->_Product->getCategories() as $Category)
	    {
		$values[] = $Category->getId();
	    }
	}
	
	$this->addElement(new \Dataservice_Form_Element_Company_Supplier_Product_CategoryMultiCheckbox("product_managecategories", array(
            'required'	    => false,
            'label'	    => 'Categories:',
	    'belongsTo'	    => 'product_managecategories',
	    'value'	    => $values
        )));
    }
}