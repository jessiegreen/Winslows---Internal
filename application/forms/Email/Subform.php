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
class Form_Email_Subform extends Zend_Form_SubForm
{
    private $_Emailaddress;
    
    public function __construct($options = null, Entities\Emailaddress $Emailaddress = null)
    {
	$this->_Emailaddress = $Emailaddress;
	
	parent::__construct($options);
    }
  
    public function init(){
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
    }
}

?>
