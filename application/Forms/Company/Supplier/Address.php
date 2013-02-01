<?php
namespace Forms\Company\Supplier;

class Address extends \Zend_Form
{    
    private $_Address;
    
    public function __construct(\Entities\Company\Supplier\Address $Address, $options = null) 
    {
	$this->_Address = $Address;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new Address\Subform($this->_Address, $options);
	
	$this->addSubForm($form, "company_supplier_address");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}