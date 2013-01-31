<?php
namespace Forms\Company\Supplier\Product;

class ManageCategories extends \Dataservice_Form
{
    private $_Product;
    
    public function __construct(\Entities\Company\Supplier\Product\ProductAbstract $Product, $options = null)
    {
	$this->_Product = $Product;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new ManageCategories\Subform($this->_Product, $options);
	
	$this->addSubForm($form, "company_supplier_product_managecategories");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}