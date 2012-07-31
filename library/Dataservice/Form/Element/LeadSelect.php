<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmployeeSelect
 *
 * @author jgreen
 */
class Dataservice_Form_Element_LeadSelect extends Zend_Form_Element_Select {
    public function init() {	
	
        $this->addMultiOption("", 'Please select...');
	
	$options = array();
	
	foreach (Services\Lead::factory()->getAllAllowedLeads() as $Lead) {
	    $options[$Lead->getId()] = $Lead->getLastName().", ".$Lead->getFirstName();
	}
	
	asort($options);
	
	$this->addMultiOptions($options);
    }
}

?>
