

<?php

class Dataservice_Form_Element_PhoneNumber extends Zend_Form_Element_Xhtml {

    public $helper = 'formPhoneNumber';

    public function isValid($value, $context = null) {
	$area = $value['area'];
	$prefix = $value['prefix'];
	$line = $value['line'];

	// Create the value for phone number.
	if (is_array($value)) {
	    $value = $area . '-' . $prefix . '-' . $line;
	    if ($value == '–') {
		$value = null;
	    }
	}

	// Check for empty phone number. (Returns true if not required.)
	if (!parent::isValid($line, $context) || !parent::isValid($prefix, $context) || !parent::isValid($line, $context)) {
	    $this->setValue($value); // Parent call to isValid will set the value to a single part, not the whole phone number.    
	    return false;
	}

	// If the user entered a number, make sure that the values are digits.
	if ($value != null) {
	    // Make sure that each fild is a number
	    $digits = new Zend_Validate_Digits();
	    $errors = array();
	    if (!$digits->isValid($area) || !$digits->isValid($prefix) || !$digits->isValid($line)) {
		$this->setValue($value); // $digits->isValid will set the value to either $area, $prefix or $line, which is not the phone number value.        
		$this->_messages = array('Please only use numbers for phone number.');
		$this->markAsError();
		return false;
	    }
	}

	// Parent resets the value.
	$this->setValue($value);
	return true;
    }

    public function getValue() {
	if (is_array($this->_value)) {
	    $value = $this->_value['area'] . '-' .
		    $this->_value['prefix'] . '-' .
		    $this->_value['line'];

	    // No value given.
	    if ($value == '–') {
		$value = null;
	    }
	    $this->setValue($value);
	}

	return parent::getValue();
    }

}

