<?php
namespace Forms\Company;

class Supplier extends \Zend_Form
{    
    private $_Supplier;
    
    public function __construct(\Entities\Company\Supplier $Supplier, $options = null)
    {
	$this->_Supplier = $Supplier;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Supplier\Subform($this->_Supplier, $options);
	
	$this->addSubForm($form, "company_supplier");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}