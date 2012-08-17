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
class Dataservice_Form_Element_OptionSelect extends Zend_Form_Element_Select
{
    public function init()
    {
        foreach(\Services\Company\Supplier\Product\Configurable\Option::factory()->getAllOptions() as $Option)
	{
            $this->addMultiOption($Option->getId(), $Option->getName());
        }
    }
}