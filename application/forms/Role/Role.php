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
class Form_Role_Role extends Zend_Form{
    private $_role;
    
    public function __construct($options = null, \Entities\Role $role = null) {
	$this->_role = $role;
	parent::__construct($options);
    }
    
    public function init($options = array()){
	if($this->_role !== null && $this->_role->getId() > 0){
	    $id = $this->addElement('hidden', 'id', array(
		'required'  => true,
		'belongsTo' => 'role',
		'value'	    => $this->_role ? $this->_role->getId() : ""
	    ));
	}
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'role',
	    'value'	    => $this->_role ? $this->_role->getName() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'belongsTo'	    => 'role',
	    'style'	    => 'width:200px;height:150px;',
	    'value'	    => $this->_role ? $this->_role->getDescription() : ""
        ));

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));

    }
}

?>
