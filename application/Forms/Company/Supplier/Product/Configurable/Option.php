<?php
namespace Forms\Company\Supplier\Product\Configurable;

class Option extends \Dataservice_Form
{    
    private $_Option;
    
    public function __construct($options = null, \Entities\Company\Supplier\Product\Configurable\Option $Option = null)
    {
	$this->_Option = $Option;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Option\Subform($options, $this->_Option);
	
	$this->addSubForm($form, "company_supplier_product_configurable_option");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}