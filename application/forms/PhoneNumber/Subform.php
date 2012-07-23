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
class Form_PhoneNumber_Subform extends Zend_Form_SubForm
{
    private $_PersonPhoneNumber;
    
    public function __construct($options = null, Entities\PersonPhoneNumber $PersonPhoneNumber = null) {
	$this->_PersonPhoneNumber = $PersonPhoneNumber;
	parent::__construct($options);
    }
  
    public function init($options = array()){
	parent::init($options);
    }
}

?>
