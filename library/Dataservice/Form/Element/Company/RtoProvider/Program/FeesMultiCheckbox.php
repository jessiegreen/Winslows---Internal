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
    private $_Program;
    
    public function __construct(\Entities\Company\RtoProvider\Program $Program, $spec, $options = null)
    {
	$this->_Program = $Program;
	
	parent::__construct($spec, $options);
    }
    
    public function init()
    {
	/* @var $Fee Entities\Company\RtoProvider\Fee\FeeAbstract */
        foreach($this->_Program->getRtoProvider()->getFees() as $Fee)
	{
            $this->addMultiOption($Fee->getId(), $Fee->getRtoProvider()->getDba()." - ".$Fee->getName());
        }
    }
}