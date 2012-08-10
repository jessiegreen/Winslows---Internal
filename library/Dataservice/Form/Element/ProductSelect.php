<?php
/**
 * Description of CompanySelect
 *
 * @author jgreen
 */
class Dataservice_Form_Element_ProductSelect extends Zend_Form_Element_Select
{
    public function init()
    {
	/* @var $Product \Entities\Company\Supplier\Product\ProductAbstract */
        foreach(Services\Company\Supplier\Product::factory()->getAllProducts() as $Product)
	{
            $this->addMultiOption($Product->getId(), $Product->getDescriminator()." - ".$Product->getName());
        }
    }
}