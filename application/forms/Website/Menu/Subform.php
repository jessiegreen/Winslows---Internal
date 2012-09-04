<?php
namespace Forms\Website\Menu;
/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Subform extends \Zend_Form_SubForm
{
    private $_MenuItem;
    
    public function __construct($options = null, \Entities\Website\Menu\Item $MenuItem = null) 
    {
	$this->_MenuItem = $MenuItem;
	parent::__construct($options);
    }
    
    public function init()
    {
	if($this->_MenuItem !== null && $this->_MenuItem->getId() > 0){
	    $this->addElement('hidden', 'id', array(
		'required'  => true,
		'belongsTo' => 'website_menu_item',
		'value'	    => $this->_MenuItem ? $this->_MenuItem->getId() : ""
	    ));
	}
	
	$this->addElement('text', 'menu_id', array(
            'required'	    => false,
	    'disabled'	    => true,
	    'description'   => $this->_MenuItem && $this->_MenuItem->getMenuId() ? $this->_MenuItem->getMenu()->getName() : "",
            'label'	    => 'Menu Id:',
	    'belongsTo'	    => 'website_menu_item',
	    'value'	    => $this->_MenuItem ? $this->_MenuItem->getMenuId() : ""
        ));
	
	$this->addElement('text', 'parent', array(
            'required'	    => false,
	    'disabled'	    => true,
	    'description'   => $this->_MenuItem && $this->_MenuItem->getParent() ? $this->_MenuItem->getParent()->getLabel() : "",
            'label'	    => 'Parent:',
	    'belongsTo'	    => 'website_menu_item',
	    'value'	    => $this->_MenuItem && $this->_MenuItem->getParent()? $this->_MenuItem->getParent()->getID() : ""
        ));
	
	$this->addElement('text', 'name_index', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'belongsTo'	    => 'website_menu_item',
	    'value'	    => $this->_MenuItem ? $this->_MenuItem->getNameIndex() : ""
        ));
	
	$this->addElement('text', 'label', array(
            'required'	    => true,
            'label'	    => 'Label:',
	    'belongsTo'	    => 'website_menu_item',
	    'value'	    => $this->_MenuItem ? $this->_MenuItem->getLabel() : ""
        ));
	
	$this->addElement('text', 'link_module', array(
            'required'	    => false,
            'label'	    => 'Link Module:',
	    'belongsTo'	    => 'website_menu_item',
	    'value'	    => $this->_MenuItem ? $this->_MenuItem->getLinkModule() : ""
        ));
	
	$this->addElement('text', 'link_controller', array(
            'required'	    => false,
            'label'	    => 'Link Controller:',
	    'belongsTo'	    => 'website_menu_item',
	    'value'	    => $this->_MenuItem ? $this->_MenuItem->getLinkController() : ""
        ));
	
	$this->addElement('text', 'link_action', array(
            'required'	    => false,
            'label'	    => 'Link Action:',
	    'belongsTo'	    => 'website_menu_item',
	    'value'	    => $this->_MenuItem ? $this->_MenuItem->getLinkAction() : ""
        ));
	
	$this->addElement('text', 'link_params', array(
            'required'	    => false,
            'label'	    => 'Link Params:',
	    'belongsTo'	    => 'website_menu_item',
	    'value'	    => $this->_MenuItem ? $this->_MenuItem->getLinkParams() : ""
        ));
	
	$this->addElement('text', 'icon', array(
            'required'	    => false,
            'label'	    => 'Icon:',
	    'belongsTo'	    => 'website_menu_item',
	    'value'	    => $this->_MenuItem ? $this->_MenuItem->getIcon() : ""
        ));
    }
}