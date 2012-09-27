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
class Dataservice_Form_Element_Company_Supplier_Product_CategorySelect extends Zend_Form_Element_Select
{
    public function init()
    {	
        $this->addMultiOption("", 'Please select...');
        
	foreach(Services\Company\Supplier\Product\Category::factory()->getAllCategories() as $Category)
	{
	    $this->addMultiOption($Category->getId(), $Category->getNameWithParentsString());
        }
    }
}