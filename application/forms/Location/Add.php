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
class Form_Location_Add extends Form_Location_Location
{        
    public function __construct($options = null) {
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$i = 1;
	$this->setIsArray(true);
        ${"form".$i} = new Form_Location_Location($options);
	unset(${"form".$i}->submit);
        $this->addElements(${"form".$i}->getElements());
	$i++;
	
	$this->addDisplayGroup(array(
		    'name',
                    'phone',
                    'type'        
            ),'location',array('legend' => 'Location Details'));
	
	${"form".$i} = new Form_Location_LocationAddress();
	unset(${"form".$i}->submit);
	$this->addElements(${"form".$i}->getElements());
	$i++;
	
	$this->addDisplayGroup(array(
			'name',
			'address_1',
			'address_2',
			'county',
			'city',
			'state',
			'zip_1',
			'zip_2'
		),'locationaddress',array('legend' => 'Address'));
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

