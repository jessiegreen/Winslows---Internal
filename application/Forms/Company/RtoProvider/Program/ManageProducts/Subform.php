<?php
namespace Forms\Company\RtoProvider\Program\ManageProducts;

class Subform extends \Zend_Form_SubForm
{
    private $_Program;
    
    public function __construct(\Entities\Company\RtoProvider\Program $Program, $options = null)
    {
	$this->_Program = $Program;
	
	parent::__construct($options);
    }
    
    public function init()
    {	
	$values = array();
	
	if($this->_Program)
	{
	    foreach($this->_Program->getProducts() as $Product)
	    {
		$values[] = $Product->getId();
	    }
	}
	
	$this->addElement(new \Dataservice_Form_Element_Company_Supplier_Product_MultiCheckbox("products_checks", array(
            'required'	    => false,
            'label'	    => 'Products:',
	    'belongsTo'	    => 'company_rto_provider_manageproducts',
	    'value'	    => $values
        )));
    }
}