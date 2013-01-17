<?php
namespace Forms\Website;

class Role extends \Dataservice_Form
{
    private $_Role;
    
    public function __construct(\Entities\Website\Role $Role = null, $options = null)
    {
	$this->_Role = $Role;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new Role\Subform($this->_Role, $options);
	
	$this->addSubForm($form, "website_role");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}