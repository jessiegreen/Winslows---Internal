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
class Form_Role extends Zend_Form{
    private $_Role;
    
    public function __construct($options = null, \Entities\Company\Website\Account\Role $Role = null) {
	$this->_Role = $Role;
	parent::__construct($options);
    }
    
    public function init($options = array()){
	$form = new Form_Role_Subform($options, $this->_Role);
	
	$this->addSubForm($form, "role");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));

    }
}

?>
