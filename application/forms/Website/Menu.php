<?php
namespace Forms\Website;
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
class Menu extends \Zend_Form
{
    private $_Menu;
    
    public function __construct($options = null, \Entities\Website\Menu $Menu = null) 
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