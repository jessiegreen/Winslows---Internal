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
class Form_Customer_Add extends Form_Customer_Customer
{        
    public function __construct($options = null) {
	parent::__construct($options, $this->_Customer);
    }
    
    public function init($options = array())
    {
	$i = 1;
	
        ${"form".$i} = new Form_Customer_Customer($options);
	unset(${"form".$i}->submit);
        $this->addElements(${"form".$i}->getElements());
	$i++;
	
	${"form".$i} = new Form_Person_Phonenumber($options);
	unset(${"form".$i}->submit);
        $this->addElements(${"form".$i}->getElements());
	$i++;
	
	${"form".$i} = new Form_PersonAddress_PersonAddress($options);
	unset(${"form".$i}->submit);
        $this->addElements(${"form".$i}->getElements());
	$i++;
	
	$this->addDisplayGroup(array(
		    'id',
		    'company',
                    'first_name',
                    'middle_name',
                    'last_name',
                    'suffix'
        
            ),'customer',array('legend' => 'Person Information'));
	$this->addDisplayGroup(array(
		    'name',
		    'address_1',
		    'address_2',
		    'city',
		    'state',
		    'zip_1',
		    'zip_2'
	    ),'address',array('legend' => 'Address'));
	
	$this->addDisplayGroup(array(
                    'type',
		    'phone_number',
		    'extension'
            ),'phonenumber',array('legend' => 'Phone Number'));
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

