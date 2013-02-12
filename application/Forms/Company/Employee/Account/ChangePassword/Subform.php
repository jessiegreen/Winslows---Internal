<?php
namespace Forms\Company\Employee\Account\ChangePassword;

class Subform extends \Forms\Company\Website\Account\ChangePassword\Subform
{    
    private $_Account;
    
    public function __construct(\Entities\Company\Employee\Account  $Account, $options = null) 
    {
	$this->_Account = $Account;
        
	parent::__construct($this->_Account, $options);
    }
    
    public function init($options = array())
    {        
	parent::init($options);
	
	$this->setElementsBelongTo("company_employee_account_change_password");
    }
}