<?php
namespace Forms\Company\Supplier\Product;

class Category extends \Zend_Form
{    
    private $_Category;
    
    public function __construct($options = null, \Entities\Company\Supplier\Product\Category $Category = null)
    {
	$this->_Category = $Category;
	parent::__construct($options, $this->_Category);
    }
    
    public function init($options = array())
    {	
        $form = new Category\Subform($options, $this->_Category);
	
	$this->addSubForm($form, "company_supplier_product_category");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}
