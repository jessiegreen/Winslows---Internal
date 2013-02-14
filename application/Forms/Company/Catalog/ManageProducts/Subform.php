<?php
namespace Forms\Company\Catalog\ManageProducts;

class Subform extends \Zend_Form_SubForm
{
    private $_Catalog;
    
    public function __construct(\Entities\Company\Catalog $Catalog, $options = null)
    {
	$this->_Catalog = $Catalog;
	
	parent::__construct($options);
    }
    
    public function init()
    {	
	$values = array();
	
	if($this->_Catalog)
	{
	    foreach($this->_Catalog->getProducts() as $Product)
	    {
		$values[] = $Product->getId();
	    }
	}
	
	$this->addElement(new \Dataservice_Form_Element_Company_Supplier_Product_MultiCheckbox("products", array(
            'required'	    => false,
            'label'	    => 'Products:',
	    'value'	    => $values
        )));
	
	$this->setElementsBelongTo("company_catalog_manage_products");
    }
}