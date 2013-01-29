<?php
namespace Forms\Company\Supplier\Product\File;

class Image extends \Dataservice_Form
{    
    private $_Image;
    
    public function __construct(\Entities\Company\Supplier\Product\File\Image $Image = null, $options = null)
    {
	$this->_Image = $Image;
	
	$this->setAttrib('enctype', 'multipart/form-data');
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Image\Subform($this->_Image, $options);
	
	$this->addSubForm($form, "company_supplier_product_file_image");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}
