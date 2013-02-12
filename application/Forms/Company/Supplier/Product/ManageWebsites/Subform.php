<?php
namespace Forms\Company\Supplier\Product\ManageWebsites;

use Entities\Company\Supplier\Product\ProductAbstract as Product;

class Subform extends \Zend_Form_SubForm
{
    private $_Product;
    
    public function __construct(Product $Product, $options = null)
    {
	$this->_Product = $Product;
	
	parent::__construct($options);
    }
    
    public function init()
    {	
	$values = array();
	
	if($this->_Product)
	{
	    foreach($this->_Product->getWebsites() as $Website)
	    {
		$values[] = $Website->getId();
	    }
	}
	
	$this->addElement(new \Dataservice_Form_Element_Company_Website_MultiCheckbox("websites", array(
            'required'	    => false,
            'label'	    => 'Websites:',
	    'value'	    => $values
        )));
	
	$this->setElementsBelongTo("company_supplier_product_manage_websites");
    }
}