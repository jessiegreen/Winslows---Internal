<?php
namespace Forms\Company;

class Customer extends \Zend_Form
{    
    private $_Customer;
    
    public function __construct($options = null, Entities\Customer $Customer = null)
    {
	$this->_Customer = $Customer;
	parent::__construct($options, $this->_Customer);
    }
    
    public function init($options = array())
    {	
        $form = new Customer\Subform($options, $this->_Customer);
	
	$this->addSubForm($form, "company_customer");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}