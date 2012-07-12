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
class Form_Person_Phonenumber extends Zend_Form
{
    private $_Phonenumber;
    private $_belongs_to;
    
    public function __construct($options = null, Entities\Phonenumber $Phonenumber = null, $belongs_to = "phonenumber") {
	$this->_Phonenumber = $Phonenumber;
	$this->_belongs_to  = $belongs_to;
	parent::__construct($options);
    }
  
    public function init($options = array()){
	if($this->_Phonenumber){
	    $type_options   = $this->_Phonenumber->getTypeOptions();
	}
	else{
	    $Phonenumber    = new \Entities\Phonenumber();
	    $type_options   = $Phonenumber->getTypeOptions();
	}
	
	$this->addElement('select', 'type', array(
            'required'	    => true,
            'label'	    => 'Type:',
	    'multioptions'  => $type_options,
	    'belongsTo'	    => $this->_belongs_to,
	    'value'	    => $this->_Phonenumber ? $this->_Phonenumber->getType() : ""
        ));
	
	$phone_number = new Dataservice_Form_Element_PhoneNumber('phoneNumber', array(
		'name'		=> 'phone_number',
		'label'		=> 'Phone Number',
		'validators'	=> array(
			array('NotEmpty', true, array('messages' => 'Please input your phone number.'))
		),
		'value'		=> $this->_Phonenumber ? $this->_Phonenumber->getAreaCode()."-".$this->_Phonenumber->getNum1()."-".$this->_Phonenumber->getNum2() : "",
		'required'	=> true,
		'belongsTo'	=> $this->_belongs_to,
		'class'		=> 'phonenumber'
	));
	
	$this->addElement($phone_number);


        $this->addElement('text', 'extension', array(
            'required'	    => false,
            'label'	    => 'Extension:',
	    'size'	    => 7,
	    'maxlength'	    => 7,
	    'belongsTo'	    => $this->_belongs_to,
	    'value'	    => $this->_Phonenumber ? $this->_Phonenumber->getExtension() : ""
        ));


        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));

    }
}

?>
