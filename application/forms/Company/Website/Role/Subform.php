<?php
namespace Forms\Company\Website\Role;

class Subform extends \Zend_Form_SubForm
{
    private $_Role;
    
    public function __construct(\Entities\Company\Website\Role $Role = null, $options = null)
    {
	$this->_Role = $Role;
	
	parent::__construct($options);
    }
    
    public function init()
    {
	$this->addElement(new \Dataservice_Form_Element_Company_WebsiteSelect("website_id", array(
            'required'	    => true,
            'label'	    => 'Website:',
	    'belongsTo'	    => 'website_menu',
	    'value'	    => $this->_Role && $this->_Role->getWebsite() ? 
				$this->_Role->getWebsite()->getId() : ""
        )));
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'website_role',
	    'value'	    => $this->_Role ? $this->_Role->getName() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'belongsTo'	    => 'website_role',
	    'style'	    => 'width:200px;height:150px;',
	    'value'	    => $this->_Role ? $this->_Role->getDescription() : ""
        ));
	
	$this->addElement('checkbox', 'admin_role', array(
            'required'	    => false,
            'label'	    => 'Admin Role?:',
	    'belongsTo'	    => 'website_role',
	    'value'	    => $this->_Role && $this->_Role->getWebsite()->getAdminRole() == $this->_Role ? 1 : 0
        ));
	
	$this->addElement('checkbox', 'guest_role', array(
            'required'	    => false,
            'label'	    => 'Guest Role?:',
	    'belongsTo'	    => 'website_role',
	    'value'	    => $this->_Role && $this->_Role->getWebsite()->getGuestRole() == $this->_Role ? 1 : 0
        ));
    }
}