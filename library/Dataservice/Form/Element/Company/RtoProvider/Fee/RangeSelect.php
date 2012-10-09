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
class Dataservice_Form_Element_Company_RtoProvider_Fee_RangeSelect extends Zend_Form_Element_Select
{
    public function init()
    {	
        $this->addMultiOption("", 'Please select...');
        
	foreach(Services\Company\RtoProvider\Fee\Range::factory()->getAllRanges() as $Range)
	{
	    $this->addMultiOption($Range->getId(), $Range->getRtoProvider()->getName()." - ".$Range->getName());
        }
    }
}