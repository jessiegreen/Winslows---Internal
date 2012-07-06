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
class Form_PersonAddress_PersonAddress extends Form_Address_Address
{    
    private $_PersonAddress;
    
    public function __construct($options = null, Entities\PersonAddress $PersonAddress = null, $belongs_to = "address") {
	$this->_PersonAddress = $PersonAddress;
	parent::__construct($options, $this->_PersonAddress, $belongs_to);
    }
    
    public function init($options = array())
    {
	parent::init($options);
    }
}

?>
