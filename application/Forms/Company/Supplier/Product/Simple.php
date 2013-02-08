<?php
namespace Forms\Company\Supplier\Product;

class Simple extends \Dataservice_Form
{    
    private $_Simple;
    
    public function __construct(\Entities\Company\Supplier\Product\Simple  $Simple, $options = null)
    {
	$this->_Simple = $Simple;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Simple\Subform($this->_Simple, $options);
	
	$this->addSubForm($form, "company_supplier_product_simple");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}