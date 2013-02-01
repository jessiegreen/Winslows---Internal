<?php
namespace Forms\Company\EmailAddress;

class Subform extends \Zend_Form_SubForm
{
    private $_EmailAddress;
    
    public function __construct(\Entities\Company\EmailAddress\EmailAddressAbstract $Emailaddress, $options = null)
    {
	$this->_EmailAddress = $Emailaddress;
	
	parent::__construct($options);
    }
  
    public function init()
    {
	if($this->_EmailAddress)
	{
	    $type_options   = $this->_EmailAddress->getTypeOptions();
	}
	else
	{
	    $Emailaddress   = new Entities\Emailaddress();
	    $type_options   = $Emailaddress->getTypeOptions();
	}
	
	$this->addElement('select', 'type', array(
            'required'	    => true,
            'label'	    => 'Type:',
	    'multioptions'  => $type_options,
	    'value'	    => $this->_EmailAddress ? $this->_EmailAddress->getType() : ""
        ));
	
	$this->addElement('text', 'address', array(
            'required'	    => true,
            'label'	    => 'Address:',
	    'validators'    => array('EmailAddress'),
	    'value'	    => $this->_EmailAddress ? $this->_EmailAddress->getAddress() : ""
        ));
	
	$this->setElementsBelongTo("company_email_address");
    }
}