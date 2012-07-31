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
class Dataservice_Form_Element_ConfigurableProductOptionSelect extends Zend_Form_Element_Select
{
    public function init()
    {
	/* @var $ConfigurableProductOption \Entities\ConfigurableProductOption */
        foreach(Services\ConfigurableProductOption::factory()->getAllConfigurableProductOptionsSortedByGroup() as $ConfigurableProductOption) {
            $this->addMultiOption($ConfigurableProductOption->getId(), $ConfigurableProductOption->getConfigurableProductOptionGroup()->getName()." - ".$ConfigurableProductOption->getName());
        }
    }
}

?>
