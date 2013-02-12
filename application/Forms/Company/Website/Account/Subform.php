<?php
namespace Forms\Company\Website\Account;

class Subform extends \Zend_Form_SubForm
{
    private $_Account;
    private $_safe;
    
    public function __construct(\Entities\Company\Website\Account\AccountAbstract $Account, $options = null, $safe = true)
    {	
	$this->_Account	    = $Account;
	$this->_safe	    = $safe;
	
	parent::__construct($options);
    }
    
    public function init()
    {
        $this->addElement(new \Dataservice_Form_Element_Company_Website_Select("website_id", array(
            'required'	    => true,
            'label'	    => 'Website:',
	    'value'	    => $this->_Account && $this->_Account->getWebsite() ? $this->_Account->getWebsite()->getId() : ""
        )));
	
	$this->addElement('text', 'username', array(
	    'required'	    => true,
	    'label'		    => 'Username:',
	    'value'		    => $this->_Account ? $this->_Account->getUsername() : ""
	));
	
	if(!$this->_Account->getPassword())
	{
	    $this->addElement('password', 'password', array(
		'required'	    => true,
		'label'		    => 'Password:',
		'validators'	=> array(array('StringLength', false, array(4,15)))
	    ));
	
	    $pwd = $this->getElement("password");

	    $pwd->addErrorMessage('Please choose a password between 4-15 characters');
	}
	
	$this->setElementsBelongTo("company_website_account");
    }
}