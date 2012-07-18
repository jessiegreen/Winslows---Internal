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
class Form_Location_Subform extends Form_Address_Subform
{    
    private $_LocationAddress;
    
    public function __construct($options = null, Entities\LocationAddress $LocationAddress = null) {
	$this->_LocationAddress = $LocationAddress;
	parent::__construct($options, $this->_LocationAddress);
    }
    
    public function init($options = array())
    {
	parent::init($options);
    }
}

?>
