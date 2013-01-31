<?php
namespace Forms\Company\FaxNumber;

class Subform extends \Zend_Form_SubForm
{
    private $_FaxNumber;
    
    public function __construct($options = null, \Entities\Company\FaxNumber\FaxNumberAbstract $FaxNumber = null)
    {
	$this->_FaxNumber = $FaxNumber;
	
	parent::__construct($options);
    }
  
    public function init()
    {
	$fax_number = new \Dataservice_Form_Element_PhoneNumber('phoneNumber', array(
		'name'		=> 'fax_number',
		'label'		=> 'Fax Number',
		'validators'	=> array(
			array('NotEmpty', true, array('messages' => 'Please phone number.'))
		),
		'value'		=> $this->_FaxNumber ? $this->_FaxNumber->getAreaCode()."-".$this->_FaxNumber->getNum1()."-".$this->_FaxNumber->getNum2() : "",
		'required'	=> true,
		'belongsTo'	=> "phone",
		'class'		=> 'phonenumber'
	));
	
	$this->addElement($fax_number);
    }
}