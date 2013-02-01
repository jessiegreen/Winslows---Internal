<?php
namespace Forms\Company\Employee;

class Account extends \Dataservice_Form
{
    private $_Account;
    private $_safe;
    
    public function __construct(\Entities\Company\Website\Account\AccountAbstract $Account, $options = null, $safe = true)
    {
	$this->_Account	    = $Account;
	$this->_safe	    = $safe;
        
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new Account\Subform($this->_Account, $options, $this->_safe);
	
	$this->addSubForm($form, "company_employee_account");
	
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}