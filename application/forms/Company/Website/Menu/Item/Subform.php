<?php
namespace Forms\Company\Website\Menu\Item;
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
    
    public function __construct($options = null, \Entities\MenuItem $MenuItem = null) {
	$this->_MenuItem = $MenuItem;
	parent::__construct($options);
    }
    
    public function init(){
	
	$this->addElement(new Dataservice_Form_Element_MenuSelect("menu_id", array(
            'required'	    => true,
            'label'	    => 'Menu:',
	    'belongsTo'	    => 'menuitem',
	    'value'	    => $this->_MenuItem && $this->_MenuItem->getMenu() ? 
				$this->_MenuItem->getMenu()->getId() : 
				""
        )));
	
	$this->addElement(new Dataservice_Form_Element_MenuItemSelect("parent_id", array(
            'required'	    => false,
            'label'	    => 'Parent:',
	    'belongsTo'	    => 'menuitem',
	    'description'   => 'Leave blank if no parent',
	    'value'	    => $this->_MenuItem && $this->_MenuItem->getParent() ? 
				$this->_MenuItem->getParent()->getId() : 
				""
        )));
	
	$this->addElement('text', 'name_index', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'belongsTo'	    => 'menuitem',
	    'value'	    => $this->_MenuItem ? $this->_MenuItem->getNameIndex() : ""
        ));
	
	$this->addElement('text', 'label', array(
            'required'	    => true,
            'label'	    => 'Label:',
	    'belongsTo'	    => 'menuitem',
	    'value'	    => $this->_MenuItem ? $this->_MenuItem->getLabel() : ""
        ));
	
	$this->addElement('text', 'link_module', array(
            'required'	    => false,
            'label'	    => 'Link Module:',
	    'belongsTo'	    => 'menuitem',
	    'value'	    => $this->_MenuItem ? $this->_MenuItem->getLinkModule() : ""
        ));
	
	$this->addElement('text', 'link_controller', array(
            'required'	    => false,
            'label'	    => 'Link Controller:',
	    'belongsTo'	    => 'menuitem',
	    'value'	    => $this->_MenuItem ? $this->_MenuItem->getLinkController() : ""
        ));
	
	$this->addElement('text', 'link_action', array(
            'required'	    => false,
            'label'	    => 'Link Action:',
	    'belongsTo'	    => 'menuitem',
	    'value'	    => $this->_MenuItem ? $this->_MenuItem->getLinkAction() : ""
        ));
	
	$this->addElement('text', 'link_params', array(
            'required'	    => false,
            'label'	    => 'Link Params:',
	    'belongsTo'	    => 'menuitem',
	    'value'	    => $this->_MenuItem ? $this->_MenuItem->getLinkParams() : ""
        ));
	
	$this->addElement('text', 'icon', array(
            'required'	    => false,
            'label'	    => 'Icon:',
	    'belongsTo'	    => 'menuitem',
	    'value'	    => $this->_MenuItem ? $this->_MenuItem->getIcon() : ""
        ));
    }
}

?>
