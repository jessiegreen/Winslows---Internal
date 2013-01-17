<?php
namespace Forms\Company\Supplier\Product\Instance\File\Image;
/**
 * Name:
 * Supplier:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Subform extends \Forms\File\Image\Subform
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
	    'belongsTo'	    => 'company_supplier_product_instance_file_image',
	    'value'	    => $this->_Image ? $this->_Image->getInstance()->getId() : ""
        ));
	
	parent::init();
    }
}