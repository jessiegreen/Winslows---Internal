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
class Form_MenuItem extends Zend_Form
{
    private $_MenuItem;
    
    public function __construct($options = null, \Entities\MenuItem $MenuItem = null)
    {
	$this->_MenuItem = $MenuItem;
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new Form_MenuItem_Subform($options, $this->_MenuItem);
	
	$this->addSubForm($form, "menuitem");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
