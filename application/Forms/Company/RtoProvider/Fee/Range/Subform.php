<?php
namespace Forms\Company\RtoProvider\Fee\Range;
/**
 * Name:
 * Product:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Subform extends \Forms\Company\RtoProvider\Fee\Subform
{
    private $_Range;
    
    public function __construct(\Entities\Company\RtoProvider\Fee\Range $Range, $options = null)
    {
	$this->_Range = $Range;
	
	parent::__construct($Range, $options);
    }
}
