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

class Form_Person_AddComplete extends Zend_Form
{
    private $_Person;
    
    public function __construct($options = null, Entities\Person $Person = null) {
	$this->_Person = $Person;
	parent::__construct($options, $this->_Person);
    }
    public function init($options = array())
    {
	$i = 1;
	
        ${"form".$i} = new Form_Person_Person($options, $this->_Person);
	unset(${"form".$i}->submit);
        $this->addElements(${"form".$i}->getElements());
	$i++;

	if(!$this->_Person || count($this->_Person->getPersonAddresses()) < 1){
	    $address_count = 1;
	    ${"form".$i} = new Form_PersonAddress_PersonAddress(array(),null,"address[1]");
	    unset(${"form".$i}->submit);
	    $this->addElements(${"form".$i}->getElements());
	    $i++;
	}
	else{
	    $address_count = 0;
	    /* @var $PersonAddress Entities\PersonAddress */
	    foreach($this->_Person->getPersonAddresses() as $PersonAddress){
		$address_count++;
		${"form".$i} = new Form_PersonAddress_PersonAddress($options, $PersonAddress, "address[".$address_count."]");
		unset(${"form".$i}->submit);
		$this->addElements(${"form".$i}->getElements());
		$i++;
	    }
	}
	
	${"form".$i} = new Form_Webaccount_Webaccount(
			    $options, 
			    $this->_Person ? $this->_Person->getWebaccount() : null
			);
	unset(${"form".$i}->submit);
        $this->addElements(${"form".$i}->getElements());
	$i++;
	
	$this->addDisplayGroup(array(
		    'id',
                    'first_name',
                    'middle_name',
                    'last_name',
                    'suffix'
        
            ),'person',array('legend' => 'Name'));
	
	for($i2 = $address_count;$i2 > 0;$i2--){
	    $this->addDisplayGroup(array(
			'name',
			'address_1',
			'address_2',
			'city',
			'state',
			'zip_1',
			'zip_2'
		),'address['.$i2.']',array('legend' => 'Address'.$i2));
	}
	
	$this->addDisplayGroup(array(
                    'username',
		    'password'
            ),'webaccount',array('legend' => 'Web Account'));
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}


?>
