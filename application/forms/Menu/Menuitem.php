<?php

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
class Form_Menu_Menuitem extends Zend_Form{
    private $_menuitem;
    
    public function __construct($options = null, \Entities\MenuItem $menuitem = null) {
	$this->_menuitem = $menuitem;
	parent::__construct($options);
    }
    
    public function init($options = array()){
	if($this->_menuitem !== null && $this->_menuitem->getId() > 0){
	    $this->addElement('hidden', 'id', array(
		'required'  => true,
		'belongsTo' => 'menuitem',
		'value'	    => $this->_menuitem ? $this->_menuitem->getId() : ""
	    ));
	}
	
	$this->addElement('text', 'menu_id', array(
            'required'	    => false,
	    'disabled'	    => true,
	    'description'   => $this->_menuitem && $this->_menuitem->getMenuId() ? $this->_menuitem->getMenu()->getName() : "",
            'label'	    => 'Menu Id:',
	    'belongsTo'	    => 'menuitem',
	    'value'	    => $this->_menuitem ? $this->_menuitem->getMenuId() : ""
        ));
	
	$this->addElement('text', 'parent', array(
            'required'	    => false,
	    'disabled'	    => true,
	    'description'   => $this->_menuitem && $this->_menuitem->getParent() ? $this->_menuitem->getParent()->getLabel() : "",
            'label'	    => 'Parent:',
	    'belongsTo'	    => 'menuitem',
	    'value'	    => $this->_menuitem && $this->_menuitem->getParent()? $this->_menuitem->getParent()->getID() : ""
        ));
	
	$this->addElement('text', 'name_index', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'belongsTo'	    => 'menuitem',
	    'value'	    => $this->_menuitem ? $this->_menuitem->getNameIndex() : ""
        ));
	
	$this->addElement('text', 'label', array(
            'required'	    => true,
            'label'	    => 'Label:',
	    'belongsTo'	    => 'menuitem',
	    'value'	    => $this->_menuitem ? $this->_menuitem->getLabel() : ""
        ));
	
	$this->addElement('text', 'link_module', array(
            'required'	    => false,
            'label'	    => 'Link Module:',
	    'belongsTo'	    => 'menuitem',
	    'value'	    => $this->_menuitem ? $this->_menuitem->getLinkModule() : ""
        ));
	
	$this->addElement('text', 'link_controller', array(
            'required'	    => false,
            'label'	    => 'Link Controller:',
	    'belongsTo'	    => 'menuitem',
	    'value'	    => $this->_menuitem ? $this->_menuitem->getLinkController() : ""
        ));
	
	$this->addElement('text', 'link_action', array(
            'required'	    => false,
            'label'	    => 'Link Action:',
	    'belongsTo'	    => 'menuitem',
	    'value'	    => $this->_menuitem ? $this->_menuitem->getLinkAction() : ""
        ));
	
	$this->addElement('text', 'link_params', array(
            'required'	    => false,
            'label'	    => 'Link Params:',
	    'belongsTo'	    => 'menuitem',
	    'value'	    => $this->_menuitem ? $this->_menuitem->getLinkParams() : ""
        ));
	
	$this->addElement('text', 'icon', array(
            'required'	    => false,
            'label'	    => 'Icon:',
	    'belongsTo'	    => 'menuitem',
	    'value'	    => $this->_menuitem ? $this->_menuitem->getIcon() : ""
        ));

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));

    }
}

?>
