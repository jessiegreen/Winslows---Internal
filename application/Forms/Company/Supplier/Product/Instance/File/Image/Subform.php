<?php
namespace Forms\Company\Supplier\Product\Instance\File\Image;

class Subform extends \Forms\Company\File\Image\Subform
{
    private $_Image;
    
    public function __construct(\Entities\Company\Supplier\Product\Instance\File\Image $Image = null, $options = null)
    {
	$this->_Image = $Image;
	
	parent::__construct($Image, $options);
    }
    
    public function init()
    {
	$this->addElement('hidden', 'instance_id', array(
            'required'	    => true,
	    'value'	    => $this->_Image ? $this->_Image->getInstance()->getId() : ""
        ));
	
	parent::init();
	
	$this->setElementsBelongTo("company_supplier_product_instance_file_image");
    }
}