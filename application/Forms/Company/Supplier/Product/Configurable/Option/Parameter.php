<?php
namespace Forms\Company\Supplier\Product\Configurable\Option;

class Parameter extends \Dataservice_Form
{    
    private $_Parameter;
    
    public function __construct(\Entities\Company\Supplier\Product\Configurable\Option\Parameter $Parameter, $options = null)
    {
	$this->_Parameter = $Parameter;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Parameter\Subform($this->_Parameter, $options);
	
	$this->addSubForm($form, "company_supplier_product_configurable_option_parameter");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}