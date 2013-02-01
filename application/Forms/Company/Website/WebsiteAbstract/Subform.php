<?php
namespace Forms\Company\Website;

class Subform extends \Zend_Form_SubForm
{
    private $_Website;
    
    public function __construct( \Entities\Company\Website\WebsiteAbstract $Website, $options = null)
    {
	$this->_Website = $Website;
	
	parent::__construct($options);
    }
    
    public function init()
    {		
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'website',
	    'value'	    => $this->_Website ? $this->_Website->getName() : ""
        ));
	
	$this->addElement('select', 'type', array(
            'required'	    => true,
            'label'	    => 'Type:',
	    'belongsTo'	    => 'website',
	    'value'	    => $this->_Website ? $this->_Website->getType() : "",
	    'multioptions'  => $this->_Website->getTypeOptions()
        ));
	
	$this->addElement('text', 'url', array(
            'required'	    => true,
            'label'	    => 'URL:',
	    'belongsTo'	    => 'website',
	    'value'	    => $this->_Website ? $this->_Website->getUrl() : ""
        ));
	
	$this->addElement('text', 'name_index', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'belongsTo'	    => 'website',
	    'value'	    => $this->_Website ? $this->_Website->getNameIndex() : ""
        ));
	
	$this->addElement('radio', 'guest_allowed', array(
            'required'	    => true,
            'label'	    => 'Guest Allowed:',
	    'belongsTo'	    => 'website',
	    'value'	    => $this->_Website ? $this->_Website->getGuestAllowed() : 0,
	    'multioptions'  => array("no", "yes")
        ));
    }
}