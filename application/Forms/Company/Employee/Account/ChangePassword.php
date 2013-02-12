<?php
namespace Forms\Company\Employee\Account;

class ChangePassword extends \Dataservice_Form
{    
    private $_Account;
    
    public function __construct(\Entities\Company\Employee\Account $Account, $options = null)
    {
	$this->_Account = $Account;
	
	$this->setAttrib("autocomplete", "off");
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new ChangePassword\Subform($this->_Account, $options);
	
	$this->addSubForm($form, "company_employee_account_change_password");
	
	$this->addElement('submit', 'submit', array(
            'ignore'	    => true,
        ));
    }
}