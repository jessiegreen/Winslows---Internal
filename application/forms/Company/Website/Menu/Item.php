<?php
namespace Forms\Company\Website\Menu;
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
	
	$this->addSubForm($form, "company_website_menu_item");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
