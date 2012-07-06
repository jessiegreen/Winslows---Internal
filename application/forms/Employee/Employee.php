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
class Form_Employee_Employee extends Form_Person_Person
{    
    private $_Employee;
    
    public function __construct($options = null, Entities\Employee $Employee = null) {
	$this->_Employee = $Employee;
	parent::__construct($options, $this->_Employee);
    }
    
    public function init($options = array())
    {
	if($this->_Employee){
	    $this->addElement('hidden', 'id', array(
		'required'  => true,
		'belongsTo' => 'employee',
		'value'	    => $this->_Employee ? $this->_Employee->getId() : ""
	    ));
	}
	
        $this->addElement('text', 'title', array(
            'required'	    => false,
            'label'	    => 'Title:',
	    'belongsTo'	    => 'employee',
	    'value'	    => $this->_Employee ? $this->_Employee->getTitle() : ""
        ));
	parent::init($options);
    }
}

?>
