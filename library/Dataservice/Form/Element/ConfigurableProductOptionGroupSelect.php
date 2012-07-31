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
class Dataservice_Form_Element_ConfigurableProductOptionGroupSelect extends Zend_Form_Element_Select
{
    public function init()
    {
        foreach(Services\ConfigurableProductOptionGroup::factory()->getAllConfigurableProductOptionGroups() as $ConfigurableProductOptionGroup) {
            $this->addMultiOption($ConfigurableProductOptionGroup->getId(), $ConfigurableProductOptionGroup->getName());
        }
    }
}

?>
