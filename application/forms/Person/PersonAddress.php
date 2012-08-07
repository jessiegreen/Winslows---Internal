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
class Form_PersonAddress extends Zend_Form
{    
    private $_PersonAddress;
    
    public function __construct($options = null, Entities\PersonAddress $PersonAddress = null)
    {
	$this->_PersonAddress = $PersonAddress;
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new Form_PersonAddress_Subform($options, $this->_PersonAddress);
	
	$this->addSubForm($form, "personaddress");
	
	$this->addElement('submit', 'submit', array(
            'ignore'	    => true,
        ));
    }
}

?>
