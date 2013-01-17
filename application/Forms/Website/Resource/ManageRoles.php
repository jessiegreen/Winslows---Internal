<?php
namespace Forms\Website\Resource;

class ManageRoles extends \Dataservice_Form
{
    private $_Resource;
    
    public function __construct(\Entities\Website\Resource $Resource, $options = null)
    {
	$this->_Resource = $Resource;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new ManageRoles\Subform($this->_Resource, $options);
	
	$this->addSubForm($form, "website_resource_manage_roles");
	
	$this->addElement('submit', 'Submit', array(
            'ignore'   => true,
        ));
    }
}