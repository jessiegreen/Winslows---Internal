<?php
class Dataservice_Form_Element_Company_Catalog_Product_MultiCheckbox extends Zend_Form_Element_MultiCheckbox
{
    protected $_Catalog;
    
    public function __construct(\Entities\Company\Catalog $Catalog, $spec, $options = null) 
    {
	$this->_Catalog = $Catalog;
	
	parent::__construct($spec, $options);
    }
    public function init()
    {
        foreach($this->_Catalog->getProducts() as $Product)
	{
            $this->addMultiOption($Product->getId(), $Product->getName());
        }
    }
}