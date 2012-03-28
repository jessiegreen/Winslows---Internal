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
    public function init($options = array())
    {
        $form1 = new Form_Person_Person;
	unset($form1->submit);
        $this->addElements($form1->getElements());

        $form2 = new Form_Address_Address();
	unset($form2->submit);
        $this->addElements($form2->getElements());
	
	$form3 = new Form_Webaccount_Webaccount();
	unset($form3->submit);
        $this->addElements($form3->getElements());
	
	$this->addDisplayGroup(array(
                    'first_name',
                    'middle_name',
                    'last_name',
                    'suffix'
        
            ),'person',array('legend' => 'Name'));
	
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
                    'username',
		    'password'
            ),'webaccount',array('legend' => 'Web Account'));
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}


?>
