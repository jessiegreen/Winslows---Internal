<?php
namespace Forms\Company\Supplier\Address;
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
class Subform extends \Forms\Address\Subform
{    
    private $_Address;
    
    public function __construct($options = null, Entities\Company\Supplier\Address $Address = null)
    {
	$this->_Address = $Address;
	
	parent::__construct($options, $this->_Address);
    }
    
    public function init($options = array())
    {
	parent::init($options);
    }
}