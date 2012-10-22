<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MenuSelect
 *
 * @author jgreen
 */
class Dataservice_Form_Element_Company_Supplier_Product_Configurable_Option_CategorySelect extends Zend_Form_Element_Select
{
    public function init()
    {	
        $this->addMultiOption("", 'Please select...');
        
	foreach(Services\Company\Supplier\Product\Configurable\Option\Category::factory()->getAllCategories() as $Category)
	{
	    $this->addMultiOption($Category->getId(), $Category->getName());
        }
    }
}