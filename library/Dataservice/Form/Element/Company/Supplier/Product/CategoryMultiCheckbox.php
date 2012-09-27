<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CompanySelect
 *
 * @author jgreen
 */
class Dataservice_Form_Element_Company_Supplier_Product_CategoryMultiCheckbox extends Zend_Form_Element_MultiCheckbox
{
    public function init()
    {
        foreach(Services\Company\Supplier\Product\Category::factory()->getAllCategories() as $Category)
	{	    
            $this->addMultiOption($Category->getId(), $Category->getNameWithParentsString());
        }
    }
}