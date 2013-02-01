<?php
namespace Forms\Company\Supplier\Product\File\Image;

class Subform extends \Forms\Company\File\Image\Subform
{
    private $_Image;
    
    public function __construct(\Entities\Company\Supplier\Product\File\Image $Image = null, $options = null)
    {
	$this->_Image = $Image;
	
	parent::__construct($Image, $options);
    }
    
    public function init()
    {
	$this->addElement(new \Dataservice_Form_Element_Company_Supplier_ProductRadio("product_id", array(
            'required'	    => false,
            'label'	    => 'Product:',
	    'belongsTo'	    => 'company_supplier_product_file_image',
	    'value'	    => $this->_Image && $this->_Image->getProduct() ? 
				$this->_Image->getProduct()->getId() : 
				""
        )));
	
	parent::init();
	
	$this->setElementsBelongTo("company_supplier_product_file_image");
    }
}