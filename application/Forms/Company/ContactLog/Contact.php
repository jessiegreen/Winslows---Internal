<?php
namespace Forms\Company\ContactLog;

class Contact extends \Dataservice_Form
{    
    private $_Contact;
    
    public function __construct(\Entities\Company\ContactLog\Contact $Contact, $options = null)
    {
	$this->_Contact = $Contact;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Contact\Subform($this->_Contact, $options);
	
	$this->addSubForm($form, "company_contact_log_contact");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
	    'style'	=> "clear:both"
        ));
    }
}