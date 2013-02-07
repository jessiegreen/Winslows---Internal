<?php
namespace Forms\Company\Website;

class Menu extends \Dataservice_Form
{
    private $_Menu;
    
    public function __construct(\Entities\Company\Website\Menu $Menu, $options = null) 
    {
	$this->_Menu = $Menu;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new Menu\Subform($this->_Menu, $options);
	
	$this->addSubForm($form, "website_menu");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}