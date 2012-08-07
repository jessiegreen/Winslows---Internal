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
class Form_PersonPhoneNumber_Subform extends Form_PhoneNumber_Subform
{
    private $_PersonPhoneNumber;
    
    public function __construct($options = null, Entities\PersonPhoneNumber $PersonPhoneNumber = null) {
	$this->_PersonPhoneNumber = $PersonPhoneNumber;
	parent::__construct($options, $this->_PersonPhoneNumber);
    }
}

?>
