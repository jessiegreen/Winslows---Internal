<?php
namespace Forms\Company\PhoneNumber;

class Subform extends \Zend_Form_SubForm
{
    private $_PhoneNumber;
    
    public function __construct(\Entities\Company\PhoneNumber\PhoneNumberAbstract $PhoneNumber, $options = null)
    {
	$this->_PhoneNumber = $PhoneNumber;
	
	parent::__construct($options);
    }
  
    public function init()
    {
	if($this->_PhoneNumber)
	{
	    $type_options   = $this->_PhoneNumber->getTypeOptions();
	}
	else
	{
	    $PhoneNumber    = new \Entities\Company\PhoneNumber();
	    $type_options   = $PhoneNumber->getTypeOptions();
	}
	
	$this->addElement('select', 'type', array(
            'required'	    => true,
            'label'	    => 'Type:',
	    'multioptions'  => $type_options,
	    'value'	    => $this->_PhoneNumber ? $this->_PhoneNumber->getType() : ""
        ));
	
	$phone_number = new \Dataservice_Form_Element_PhoneNumber('phoneNumber', array(
		'name'		=> 'phone_number',
		'label'		=> 'Phone Number',
		'validators'	=> array(
			array('NotEmpty', true, array('messages' => 'Please phone number.'))
		),
		'value'		=> $this->_PhoneNumber ? $this->_PhoneNumber->getAreaCode()."-".$this->_PhoneNumber->getNum1()."-".$this->_PhoneNumber->getNum2() : "",
		'required'	=> true,
		'class'		=> 'phonenumber'
	));
	
	$this->addElement($phone_number);


        $this->addElement('text', 'extension', array(
            'required'	    => false,
            'label'	    => 'Extension:',
	    'size'	    => 7,
	    'maxlength'	    => 7,
	    'value'	    => $this->_PhoneNumber ? $this->_PhoneNumber->getExtension() : ""
        ));
	
	$this->setElementsBelongTo("company_phone_number");
    }
}