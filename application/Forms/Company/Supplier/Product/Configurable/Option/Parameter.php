<?php
namespace Forms\Company\Supplier\Product\Configurable\Option;

class Parameter extends \Zend_Form
{    
    private $_Parameter;
    
    public function __construct($options = null, \Entities\Company\Supplier\Product\Configurable\Option\Parameter $Parameter = null)
    {
	$this->_Parameter = $Parameter;
	
	parent::__construct($options, $this->_Parameter);
    }
    
    public function init($options = array())
    {	
        $form = new Parameter\Subform($options, $this->_Parameter);
	
	$this->addSubForm($form, "company_supplier_product_configurable_option_parameter");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}