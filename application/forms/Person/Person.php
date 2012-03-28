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
class Form_Person_Person extends Zend_Form
{
    public function init($options = array()){
        $this->addElement('text', 'first_name', array(
            'required'   => true,
            'label'      => 'First Name:',
	    'belongsTo' => 'person'
        ));

        $this->addElement('text', 'middle_name', array(
            'required'   => false,
            'label'      => 'Middle Name:',
	    'belongsTo' => 'person'
        ));
	
	$this->addElement('text', 'last_name', array(
            'required'   => true,
            'label'      => 'Last Name:',
	    'belongsTo' => 'person'
        ));
	
	$this->addElement('text', 'suffix', array(
            'required'   => false,
            'label'      => 'Suffix:',
	    'belongsTo' => 'person'
        ));

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));

    }
}

?>
