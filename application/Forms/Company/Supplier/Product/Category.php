<?php
namespace Forms\Company\Supplier\Product;

class Category extends \Zend_Form
{    
    private $_Category;
    
    public function __construct(\Entities\Company\Supplier\Product\Category $Category, $options = null)
    {
	$this->_Category = $Category;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Category\Subform($this->_Category, $options);
	
	$this->addSubForm($form, "company_supplier_product_category");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}
