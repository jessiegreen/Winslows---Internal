<?php
namespace Forms\Company\Supplier\Product\Configurable\Option\Parameter;

class Value extends \Zend_Form
{    
    private $_Value;
    
    public function __construct(\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value $Value, $options = null)
    {
	$this->_Value = $Value;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Value\Subform($this->_Value, $options);
	
	$this->addSubForm($form, "company_supplier_product_configurable_option_parameter_value");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}