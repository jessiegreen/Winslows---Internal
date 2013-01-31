<?php
namespace Forms\Company\Website;

class Menu extends \Zend_Form
{
    private $_Menu;
    
    public function __construct($options = null, \Entities\Company\Website\Menu $Menu = null) 
    {
	$this->_Menu = $Menu;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new Menu\Subform($options, $this->_Menu);
	
	$this->addSubForm($form, "website_menu");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}