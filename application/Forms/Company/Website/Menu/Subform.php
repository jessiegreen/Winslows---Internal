<?php
namespace Forms\Company\Website\Menu;

class Subform extends \Zend_Form_SubForm
{
    private $_Menu;
    
    public function __construct(\Entities\Company\Website\Menu $Menu, $options = null) 
    {
	$this->_Menu = $Menu;
	
	parent::__construct($options);
    }
    
    public function init()
    {	
	$this->addElement(new \Dataservice_Form_Element_Company_WebsiteSelect("website_id", array(
            'required'	    => true,
            'label'	    => 'Website:',
	    'value'	    => $this->_Menu && $this->_Menu->getWebsite() ? 
				$this->_Menu->getWebsite()->getId() : ""
        )));
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'value'	    => $this->_Menu ? $this->_Menu->getName() : ""
        ));
        
        $this->addElement('text', 'name_index', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'value'	    => $this->_Menu ? $this->_Menu->getNameIndex() : ""
        ));
	
	
	$this->setElementsBelongTo("company_website_menu");
    }
}