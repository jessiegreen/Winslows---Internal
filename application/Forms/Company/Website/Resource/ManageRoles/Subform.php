<?php
namespace Forms\Company\Website\Resource\ManageRoles;

class Subform extends \Zend_Form_SubForm
{
    private $_Resource;
    
    public function __construct(\Entities\Company\Website\Resource $Resource, $options = null)
    {
	$this->_Resource = $Resource;
	
	parent::__construct($options);
    }
    
    public function init()
    {	
	$values = array();
	
	if($this->_Resource)
	{
	    foreach($this->_Resource->getRoles() as $Role)
	    {
		$values[] = $Role->getId();
	    }
	}
	
	$this->addElement(new \Dataservice_Form_Element_Company_Website_Roles_MultiCheckbox(
		$this->_Resource->getWebsite(),
		"role_id", 
		array(
		    'required'	    => true,
		    'label'	    => 'Roles:',
		    'belongsTo'	    => 'company_employee_resource_manage_roles',
		    'value'	    => $values
		)
	    ));
    }
}