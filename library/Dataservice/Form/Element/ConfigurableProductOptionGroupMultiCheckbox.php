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
class Dataservice_Form_Element_ConfigurableProductOptionGroupMultiCheckbox extends Zend_Form_Element_MultiCheckbox
{
    public function init()
    {
        foreach(Services\ConfigurableProductOptionGroup::factory()->getAllConfigurableProductOptionGroups() as $ConfigurableProductOptionGroup) {
            $this->addMultiOption($ConfigurableProductOptionGroup->getId(), $ConfigurableProductOptionGroup->getName());
        }
    }
}

?>
