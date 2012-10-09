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
class Dataservice_Form_Element_Company_RtoProvider_Program_FeesMultiCheckbox extends Zend_Form_Element_MultiCheckbox
{
    public function init()
    {
        foreach(Services\Company\RtoProvider\Fee::factory()->getAllFees() as $Fee)
	{
            $this->addMultiOption($Fee->getId(), $Fee->getName());
        }
    }
}