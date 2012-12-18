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
class Dataservice_Form_Element_ParameterSelect extends Zend_Form_Element_Select
{
    public function init()
    {
	/* @var $Parameter \Entities\Company\Supplier\Product\Configurable\Option\Parameter */
        foreach(Services\Company\Supplier\Product\Configurable\Option\Parameter::factory()->getAllParametersSortedByOption() as $Parameter) 
	{
            $this->addMultiOption($Parameter->getId(), $Parameter->getOption()->getName()." - ".$Parameter->getName());
        }
    }
}