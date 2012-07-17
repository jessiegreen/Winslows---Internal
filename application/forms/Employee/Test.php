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
class Form_Employee_Test extends Form_Person_Person
{    
    protected $_Employee;
    
    public function __construct($options = null, $Employee = null) {
	$this->_Employee = $Employee;
	parent::__construct();
    }
    
    public function init($options = array())
    {	
        $this->addElement('text', 'title', array(
            'required'	    => false,
            'label'	    => 'Title:',
	    'belongsTo'	    => 'employee',
	    'value'	    => $this->_Employee ? $this->_Employee->getTitle() : ""
        ));
	
	parent::init();
    }
}

?>
