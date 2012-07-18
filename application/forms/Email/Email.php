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
class Form_Person_EmailAddress extends Zend_Form
{
    private $_Emailaddress;
    private $_belongs_to;
    
    public function __construct($options = null, Entities\Emailaddress $Emailaddress = null, $belongs_to = "emailaddress") {
	$this->_Emailaddress = $Emailaddress;
	$this->_belongs_to  = $belongs_to;
	parent::__construct($options);
    }
  
    public function init($options = array()){
	if($this->_Emailaddress){
	    $type_options   = $this->_Emailaddress->getTypeOptions();
	}
	else{
	    $Emailaddress    = new Entities\Emailaddress();
	    $type_options   = $Emailaddress->getTypeOptions();
	}
	
	$this->addElement('select', 'type', array(
            'required'	    => true,
            'label'	    => 'Type:',
	    'multioptions'  => $type_options,
	    'belongsTo'	    => $this->_belongs_to,
	    'value'	    => $this->_Emailaddress ? $this->_Emailaddress->getType() : ""
        ));
	
	$this->addElement('text', 'address', array(
            'required'	    => true,
            'label'	    => 'Address:',
	    'validators'    => array('EmailAddress'),
	    'belongsTo'	    => $this->_belongs_to,
	    'value'	    => $this->_Emailaddress ? $this->_Emailaddress->getAddress() : ""
        ));

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));

    }
}

?>
