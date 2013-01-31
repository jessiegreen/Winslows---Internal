<?php
namespace Forms\Company\Website\Account\ManageRoles;

class Subform extends \Zend_Form_SubForm
{
    private $_Account;
    
    public function __construct(\Entities\Company\Website\Account\AccountAbstract $Account, $options = null)
    {
	$this->_Account = $Account;
	
	parent::__construct($options);
    }
    
    public function init()
    {	
	$values = array();
	
	if($this->_Account)
	{
	    foreach($this->_Account->getRoles() as $Role)
	    {
		$values[] = $Role->getId();
	    }
	}
	
	$this->addElement(new \Dataservice_Form_Element_Company_Website_Roles_MultiCheckbox(
		$this->_Account->getWebsite(),
		"role_id", 
		array(
		    'required'	    => true,
		    'label'	    => 'Roles:',
		    'belongsTo'	    => 'company_employee_account_manage_roles',
		    'value'	    => $values
		)
	    ));
    }
}