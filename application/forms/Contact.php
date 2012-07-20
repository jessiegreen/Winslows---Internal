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
class Form_Contact extends Zend_Form
{
    private $_Contact;
    
    public function __construct($options = null, Entities\Contact $Contact = null) {
	$this->_Contact	    = $Contact;
	parent::__construct($options);
    }
  
    public function init($options = array()){
	$form = new Form_Contact_Subform($options, $this->_Contact);
	
	$this->addSubForm($form, "contact");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
