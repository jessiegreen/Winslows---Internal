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
class Dataservice_Form_Element_ProductSelect extends Zend_Form_Element_Select
{
    public function init()
    {
	/* @var $Product \Entities\Product */
        foreach(Services\Product::factory()->getAllProducts() as $Product) {
            $this->addMultiOption($Product->getId(), $Product->getDescriminator()." - ".$Product->getName());
        }
    }
}

?>
