<?php

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
class Form_PersonAddress_Subform extends Form_Address_Subform
{    
    private $_PersonAddress;
    
    public function __construct($options = null, Entities\PersonAddress $PersonAddress = null) {
	$this->_PersonAddress = $PersonAddress;
	parent::__construct($options, $this->_PersonAddress);
    }
    
    public function init($options = array())
    {
	parent::init($options);
    }
}

?>
