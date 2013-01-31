<?php
namespace Forms\Company\File\Image;

class Subform extends \Forms\Company\File\Subform
{
    private $_Image;
    
    public function __construct( \Entities\Company\File\Image\ImageAbstract $Image, $options = null)
    {
	$this->_Image = $Image;
	
	parent::__construct($Image, $options);
    }
    
    public function init()
    {	
	parent::init();
    }
}