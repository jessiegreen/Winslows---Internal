<?php
namespace Forms\Company\Supplier\Product\Category\File\Image;

class Subform extends \Forms\Company\File\Image\Subform
{
    private $_Image;
    
    public function __construct(\Entities\Company\Supplier\Product\Category\File\Image $Image = null, $options = null)
    {
	$this->_Image = $Image;
	
	parent::__construct($Image, $options);
    }
    
    public function init()
    {
	$this->addElement(new \Dataservice_Form_Element_Company_Supplier_Product_CategorySelect("category_id", array(
            'required'	    => false,
            'label'	    => 'Category:',
	    'value'	    => $this->_Image && $this->_Image->getCategory() ? 
				$this->_Image->getCategory()->getId() : 
				""
        )));
	
	parent::init();
	
	$this->setElementsBelongTo("company_supplier_product_category_file_image");
    }
}