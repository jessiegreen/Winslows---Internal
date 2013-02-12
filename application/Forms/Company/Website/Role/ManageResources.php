<?php
namespace Forms\Company\Website\Role;

class ManageResources extends \Dataservice_Form
{
    private $_Role;
    
    public function __construct(\Entities\Company\Website\Role $Role, $options = null)
    {
	$this->_Role = $Role;
	
	parent::__construct($options);
    }
    
    public function init()
    {
	$form = new ManageResources\Subform($this->_Role);
	
	$this->addSubForm($form, "company_website_role_manage_resources");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}