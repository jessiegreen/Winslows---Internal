<?php
namespace Forms\Company\Website\Menu;

class Subform extends \Zend_Form_SubForm
{
    private $_Menu;
    
    public function __construct($options = null, \Entities\Company\Website\Menu $Menu = null) 
    {
	$this->_Menu = $Menu;
	
	parent::__construct($options);
    }
    
    public function init()
    {	
	$this->addElement(new \Dataservice_Form_Element_Company_WebsiteSelect("website_id", array(
            'required'	    => true,
            'label'	    => 'Website:',
	    'belongsTo'	    => 'website_menu',
	    'value'	    => $this->_Menu && $this->_Menu->getWebsite() ? 
				$this->_Menu->getWebsite()->getId() : ""
        )));
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'website_menu',
	    'value'	    => $this->_Menu ? $this->_Menu->getName() : ""
        ));
        
        $this->addElement('text', 'name_index', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'belongsTo'	    => 'website_menu',
	    'value'	    => $this->_Menu ? $this->_Menu->getNameIndex() : ""
        ));
    }
}