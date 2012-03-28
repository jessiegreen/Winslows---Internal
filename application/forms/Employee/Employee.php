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
class Form_Employee_Employee extends Form_Person_Person{
    public function init($options = array()){
        $this->addElement('text', 'title', array(
            'required'	    => true,
            'label'	    => 'Title:',
	    'belongsTo'	    => 'employee'
        ));
    }
}

?>
