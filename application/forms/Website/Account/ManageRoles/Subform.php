<?php
namespace Forms\Website\Account\ManageRoles;
/**
 * Name:
 * Product:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Subform extends \Zend_Form_SubForm
{
    private $_Account;
    
    public function __construct(\Entities\Website\Account\AccountAbstract $Account, $options = null)
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
	
	$this->addElement(new \Dataservice_Form_Element_Website_Roles_MultiCheckbox(
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