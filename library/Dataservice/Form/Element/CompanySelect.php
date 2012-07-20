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
class Dataservice_Form_Element_CompanySelect extends Zend_Form_Element_Select {
    public function init() {	
        $this->addMultiOption("", 'Please select...');
        foreach (Services\Company::factory()->getCompanies() as $Company) {
            $this->addMultiOption($Company->getId(), $Company->getName());
        }
    }
}

?>
