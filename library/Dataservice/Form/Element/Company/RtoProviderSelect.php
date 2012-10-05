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
class Dataservice_Form_Element_Company_RtoProviderSelect extends Zend_Form_Element_Select
{
    public function init()
    {	
        $this->addMultiOption("", 'Please select...');
	
        foreach (Services\Company\RtoProvider::factory()->getAllRtoProviders() as $RtoProvider)
	{
            $this->addMultiOption($RtoProvider->getId(), $RtoProvider->getName());
        }
    }
}
