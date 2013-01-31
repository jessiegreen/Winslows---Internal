<?php
namespace Forms\Company\Website\Account;

class ManageRoles extends \Dataservice_Form
{
    private $_Account;
    
    public function __construct(\Entities\Company\Website\Account\AccountAbstract $Account, $options = null)
    {
	$this->_Account = $Account;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new ManageRoles\Subform($this->_Account, $options);
	
	$this->addSubForm($form, "website_account_manage_roles");
	
	$this->addElement('submit', 'Submit', array(
            'ignore'   => true,
        ));
    }
}