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
class Form_Location_LocationAddress extends Form_Address_Address
{    
    private $_LocationAddress;
    
    public function __construct($options = null, Entities\LocationAddress $LocationAddress = null, $belongs_to = "locationaddress") {
	$this->_LocationAddress = $LocationAddress;
	parent::__construct($options, $this->_LocationAddress, $belongs_to);
    }
    
    public function init($options = array())
    {
	parent::init($options);
    }
}

?>
