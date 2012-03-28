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
class Form_Address_Address extends Zend_Form{
    public function init($options = array()){
	$this->addElement('text', 'name', array(
            'required'   => true,
            'label'      => 'Location Name:',
	    'belongsTo' => 'address',
	    'description'   => '(Ex. Home)'
        ));
	
        $this->addElement('text', 'address_1', array(
            'required'   => true,
            'label'      => 'Address Line 1:',
	    'belongsTo' => 'address'
        ));
	
	$this->addElement('text', 'address_2', array(
            'required'   => false,
            'label'      => 'Address Line 2:',
	    'belongsTo' => 'address'
        ));

        $this->addElement('text', 'city', array(
            'required'   => true,
            'label'      => 'City:',
	    'belongsTo' => 'address'
        ));
	
	$this->addElement('text', 'state', array(
            'required'   => true,
            'label'      => 'State:',
	    'size'	 => '2',
	    'belongsTo' => 'address'
        ));
	
	$this->addElement('text', 'zip_1', array(
            'required'   => true,
            'label'      => 'Zip:',
	    'size'	 => '5',
	    'belongsTo' => 'address'
        ));
	
	$this->addElement('text', 'zip_2', array(
            'required'   => false,
            'label'      => 'Zip Extension:',
	    'size'	 => '5',
	    'belongsTo' => 'address'
        ));

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));

    }
}

?>
