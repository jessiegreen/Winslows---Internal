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
class Form_Phone_Subform extends Zend_Form_SubForm
{
    private $_Phone;
    
    public function __construct($options = null, Entities\Phonenumber $Phonenumber = null) {
	$this->_Phone = $Phonenumber;
	parent::__construct($options);
    }
  
    public function init(){
	if($this->_Phone){
	    $type_options   = $this->_Phone->getTypeOptions();
	}
	else{
	    $Phonenumber    = new \Entities\Phonenumber();
	    $type_options   = $Phonenumber->getTypeOptions();
	}
	
	$this->addElement('select', 'type', array(
            'required'	    => true,
            'label'	    => 'Type:',
	    'multioptions'  => $type_options,
	    'belongsTo'	    => "phone",
	    'value'	    => $this->_Phone ? $this->_Phone->getType() : ""
        ));
	
	$phone_number = new Dataservice_Form_Element_PhoneNumber('phoneNumber', array(
		'name'		=> 'phone_number',
		'label'		=> 'Phone Number',
		'validators'	=> array(
			array('NotEmpty', true, array('messages' => 'Please input your phone number.'))
		),
		'value'		=> $this->_Phone ? $this->_Phone->getAreaCode()."-".$this->_Phone->getNum1()."-".$this->_Phone->getNum2() : "",
		'required'	=> true,
		'belongsTo'	=> "phone",
		'class'		=> 'phonenumber'
	));
	
	$this->addElement($phone_number);


        $this->addElement('text', 'extension', array(
            'required'	    => false,
            'label'	    => 'Extension:',
	    'size'	    => 7,
	    'maxlength'	    => 7,
	    'belongsTo'	    => "phone",
	    'value'	    => $this->_Phone ? $this->_Phone->getExtension() : ""
        ));
    }
}

?>
