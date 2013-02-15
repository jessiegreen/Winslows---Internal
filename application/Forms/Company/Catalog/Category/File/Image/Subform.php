<?php
namespace Forms\Company\Catalog\Category\File\Image;

class Subform extends \Forms\Company\File\Image\Subform
{
    private $_Image;
    
    public function __construct(\Entities\Company\Catalog\Category\File\Image $Image = null, $options = null)
    {
	$this->_Image = $Image;
	
	parent::__construct($Image, $options);
    }
    
    public function init()
    {
	$this->addElement(new \Dataservice_Form_Element_Company_Catalog_Category_Select(
	    $this->_Image->getCategory(),
	    "category_id", 
	    array(
		'required'	    => false,
		'label'	    => 'Category:',
		'value'	    => $this->_Image && $this->_Image->getCategory() ? 
				    $this->_Image->getCategory()->getId() : 
				    ""
	    )));
	
	parent::init();
	
	$this->setElementsBelongTo("company_catalog_category_file_image");
    }
}