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
class Form_LocationPhoneNumber_Subform extends Form_PhoneNumber_Subform
{
    private $_LocationPhoneNumber;
    
    public function __construct($options = null, Entities\LocationPhoneNumber $PhoneNumber = null) {
	$this->_LocationPhoneNumber = $PhoneNumber;
	parent::__construct($options, $this->_LocationPhoneNumber);
    }
}

?>
