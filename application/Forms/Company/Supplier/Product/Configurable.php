<?php
namespace Forms\Company\Supplier\Product;

class Configurable extends \Zend_Form
{    
    private $_Configurable;
    
    public function __construct(\Entities\Company\Supplier\Product\Configurable $Configurable, $options = null)
    {
	$this->_Configurable = $Configurable;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Configurable\Subform($this->_Configurable, $options);
	
	$this->addSubForm($form, "company_supplier_product_configurable");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}
