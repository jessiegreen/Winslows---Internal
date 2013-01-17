<?php
namespace Forms\File\Image;
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
class Subform extends \Forms\File\Subform
{
    private $_Image;
    
    public function __construct( \Entities\File\Image\ImageAbstract $Image, $options = null)
    {
	$this->_Image = $Image;
	
	parent::__construct($Image, $options);
    }
    
    public function init()
    {	
	parent::init();
    }
}