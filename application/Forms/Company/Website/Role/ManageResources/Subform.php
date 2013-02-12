<?php
namespace Forms\Company\Website\Role\ManageResources;

class Subform extends \Zend_Form_SubForm
{
    private $_Role;
    
    public function __construct(\Entities\Company\Website\Role $Role, $options = null)
    {
	$this->_Role = $Role;
	
	parent::__construct($options);
    }
    
    public function init()
    {	
	$values = array();
	
	if($this->_Role)
	{
	    foreach($this->_Role->getResources() as $Resource)
	    {
		$values[] = $Resource->getId();
	    }
	}
	
	$this->addElement(new \Dataservice_Form_Element_Company_Website_Role_Resources_MultiCheckbox(
		$this->_Role,
		"resources", array(
		    'required'	    => false,
		    'label'	    => 'Resources:',
		    'belongsTo'	    => 'company_website_role_manage_resources',
		    'value'	    => $values
		)));
    }
}