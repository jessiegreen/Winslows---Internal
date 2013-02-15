<?php
class Dataservice_Form_Element_Company_Supplier_Product_File_Image_Radio extends Zend_Form_Element_Radio
{
    protected $_Product;
    
    public function __construct(\Entities\Company\Supplier\Product\ProductAbstract $Product, $spec, $options = null)
    {
	$this->_Product = $Product;
	
	parent::__construct($spec, $options);
    }
    
    public function init()
    {
        foreach($this->_Product->getImages() as $Image)
	{
            $this->addMultiOption($Image->getId(), $Image->getName());
        }
    }
}