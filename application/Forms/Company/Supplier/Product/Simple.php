<?php
namespace Forms\Company\Supplier\Product;

class Simple extends \Zend_Form
{    
    private $_Simple;
    
    public function __construct($options = null, \Entities\Company\Supplier\Product\Simple  $Simple = null)
    {
	$this->_Simple = $Simple;
	
	parent::__construct($options, $this->_Simple);
    }
    
    public function init($options = array())
    {	
        $form = new Simple\Subform($options, $this->_Simple);
	
	$this->addSubForm($form, "company_supplier_product_simple");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}