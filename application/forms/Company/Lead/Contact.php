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
    private $_Lead;
    
    public function __construct(\Entities\Lead $Lead, $options = null, Entities\Contact $Contact = null) {
	$this->_Contact	    = $Contact;
	$this->_Lead	    = $Lead;
	parent::__construct($options);
    }
  
    public function init($options = array()){
	$form = new Form_Contact_Subform($this->_Lead, $options, $this->_Contact);
	
	$this->addSubForm($form, "contact");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
