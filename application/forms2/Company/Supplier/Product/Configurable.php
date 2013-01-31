<?php
namespace Forms\Company\Supplier\Product;

class Configurable extends \Zend_Form
{    
    private $_Configurable;
    
    public function __construct($options = null, \Entities\Company\Supplier\Product\Configurable $Configurable = null)
    {
	$this->_Configurable = $Configurable;
	
	parent::__construct($options, $this->_Configurable);
    }
    
    public function init($options = array())
    {	
        $form = new Configurable\Subform($options, $this->_Configurable);
	
	$this->addSubForm($form, "company_supplier_product_configurable");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}
