<?php
namespace Forms\Company\Website\Menu;

class Item extends \Zend_Form
{
    private $_MenuItem;
    
    public function __construct($options = null, \Entities\Company\Website\Menu\Item $MenuItem = null)
    {
	$this->_MenuItem = $MenuItem;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new Item\Subform($options, $this->_MenuItem);
	
	$this->addSubForm($form, "website_menu_item");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}