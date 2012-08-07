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
class Form_PersonPhoneNumber extends Zend_Form
{    
    private $_PersonPhoneNumber;
    
    public function __construct($options = null, Entities\PersonPhoneNumber $PersonPhoneNumber = null)
    {
	$this->_PersonPhoneNumber = $PersonPhoneNumber;
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new Form_PersonPhoneNumber_Subform($options, $this->_PersonPhoneNumber);
	
	$this->addSubForm($form, "personphonenumber");
	
	$this->addElement('submit', 'submit', array(
            'ignore'	    => true,
        ));
    }
}

?>
