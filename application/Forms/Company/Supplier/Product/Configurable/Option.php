<?php
namespace Forms\Company\Supplier\Product\Configurable;

class Option extends \Dataservice_Form
{    
    private $_Option;
    
    public function __construct(\Entities\Company\Supplier\Product\Configurable\Option $Option, $options = null)
    {
	$this->_Option = $Option;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Option\Subform($this->_Option, $options);
	
	$this->addSubForm($form, "company_supplier_product_configurable_option");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}