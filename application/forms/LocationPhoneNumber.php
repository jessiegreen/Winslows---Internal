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
class Form_LocationPhoneNumber extends Zend_Form
{    
    private $_LocationPhoneNumber;
    
    public function __construct($options = null, Entities\LocationPhoneNumber $LocationPhoneNumber = null)
    {
	$this->_LocationPhoneNumber = $LocationPhoneNumber;
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new Form_LocationPhoneNumber_Subform($options, $this->_LocationPhoneNumber);
	
	$this->addSubForm($form, "locationphonenumber");
	
	$this->addElement('submit', 'submit', array(
            'ignore'	    => true,
        ));
    }
}

?>
