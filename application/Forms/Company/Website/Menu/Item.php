<?php
namespace Forms\Company\Website\Menu;

class Item extends \Zend_Form
{
    private $_MenuItem;
    
    public function __construct(\Entities\Company\Website\Menu\Item $MenuItem, $options = null)
    {
	$this->_MenuItem = $MenuItem;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new Item\Subform($this->_MenuItem, $options);
	
	$this->addSubForm($form, "company_website_menu_item");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}