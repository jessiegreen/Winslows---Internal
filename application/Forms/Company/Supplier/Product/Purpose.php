<?php
namespace Forms\Company\Supplier\Product;

class Purpose extends \Dataservice_Form
{    
    private $_Purpose;
    
    public function __construct(\Entities\Company\Supplier\Product\Purpose $Purpose = null, $options = null)
    {
	$this->_Purpose = $Purpose;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Purpose\Subform($this->_Purpose, $options);
	
	$this->addSubForm($form, "company_supplier_product_purpose");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}
