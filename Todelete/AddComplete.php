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
    protected $_Person;
    
    public function __construct($options = null, Entities\Person\PersonAbstract $Person = null) {
	$this->_Person = $Person;
	parent::__construct($options, $this->_Person);
    }
    public function init($options = array())
    {	
        $form = new Form_Person_Person(array(), $this->_Person);
	$form->removeElement("submit");
	$form->setIsArray(true);
	$form->removeDecorator('form');
	$form->setLegend("Info");
	$form->setDecorators(array(
		    'FormElements',
		    'Fieldset',
		    array('HtmlTag',array('tag'=>'div'))
	));
        $this->addSubForm($form, "form_person");

	if(!$this->_Person || count($this->_Person->getAddresses()) < 1){
	    $address_count = 1;
	    $form = new Form_PersonAddress_PersonAddress(array(),null);
	    $form->removeElement("submit");
	    $form->setIsArray(true);
	    $form->removeDecorator('form');
	    $form->setLegend("Address");
	    $form->setDecorators(array(
			'FormElements',
			'Fieldset',
			array('HtmlTag',array('tag'=>'div'))
	    ));
	    $this->addSubForm($form, "form_address");
	}
	else{
	    $address_count = 0;
	    /* @var $PersonAddress Entities\Person\Address */
	    foreach($this->_Person->getAddresses() as $PersonAddress){
		$form = new Form_PersonAddress_PersonAddress($options, $PersonAddress);
		$form->removeElement("submit");
		$form->setIsArray(true);
		$form->removeDecorator('form');
		$form->setLegend("Address ".($address_count+1));
		$form->setDecorators(array(
		    'FormElements',
		    'Fieldset',
		    array('HtmlTag',array('tag'=>'div'))
		));
		$this->addSubForm($form, "form_address_".$address_count);
		$address_count++;
	    }
	}
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}


?>
