<?php
namespace Forms\Company\Website\Account\ChangePassword;

class Subform extends \Zend_Form_SubForm
{
    private $_Account;
    
    public function __construct(\Entities\Company\Website\Account\AccountAbstract $Account, $options = null)
    {	
	$this->_Account	    = $Account;
	
	parent::__construct($options);
    }
    
    public function init()
    {
	$UserAccount = \Services\Company\Website::factory()
			->getCurrentWebsite()
			->getCurrentUserAccount(\Zend_Auth::getInstance());
	
	if(!$UserAccount->hasRoleByRoleNames(array("Admin", "Manager")))
	{
	    $this->addElement('password', 'password_old', array(
		'required'	=> true,
		'label'		=> 'Old Password:',
		'validators'	=> array(new \Dataservice_Validate_Company_Website_Account_Password_MatchesOld()),
	    ));
	}
	
	$this->addElement('password', 'password', array(
		'required'	=> true,
		'label'		=> 'New Password:',
		'validators'	=> array(array('StringLength', false, array(4,15)))
	    ));
	
	$pwd = $this->getElement("password");
	
	$pwd->addErrorMessage('Please choose a password between 4-15 characters');
	
	$this->addElement('password', 'password_confirm', array(
		'required'	=> true,
		'label'		=> 'Confirm New Password:',
		'validators'	=> array(array('Identical', false, array('token' => 'password')))
	    ));
	
	$confirm = $this->getElement("password_confirm");
	
	$confirm->addErrorMessage('The passwords do not match');
	
	$this->setElementsBelongTo("company_website_account_change_password");
    }
}