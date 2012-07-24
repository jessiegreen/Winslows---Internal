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
class Form_PersonEmailAddress extends Zend_Form
{    
    private $_PersonEmailAddress;
    
    public function __construct($options = null, Entities\PersonEmailAddress $PersonEmailAddress = null)
    {
	$this->_PersonEmailAddress = $PersonEmailAddress;
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new Form_PersonEmailAddress_Subform($options, $this->_PersonEmailAddress);
	
	$this->addSubForm($form, "personemailaddress");
	
	$this->addElement('submit', 'submit', array(
            'ignore'	    => true,
        ));
    }
}

?>
