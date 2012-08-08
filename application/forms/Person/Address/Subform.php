<?php
namespace Forms\Person\Address;
/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Subform extends Forms\Address\Subform
{    
    private $_PersonAddress;
    
    public function __construct($options = null, Entities\Person\Address $PersonAddress = null) {
	$this->_PersonAddress = $PersonAddress;
	parent::__construct($options, $this->_PersonAddress);
    }
    
    public function init($options = array())
    {
	parent::init($options);
    }
}

?>
