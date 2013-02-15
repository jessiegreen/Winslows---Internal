<?php
namespace Forms\Company\Supplier\Product\SetDefaultImage;

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
	$this->addElement(new \Dataservice_Form_Element_Company_Supplier_Product_File_Image_Radio(
		$this->_Product,
		"default_image", 
		array(
		    'required'	    => false,
		    'label'	    => 'Product Images:',
		    'value'	    => $this->_Product && $this->_Product->getDefaultImage() ? 
					    $this->_Product->getDefaultImage()->getId() : ""
		)
	    )
	);
	
	$this->setElementsBelongTo("company_supplier_product_set_default_image");
    }
}