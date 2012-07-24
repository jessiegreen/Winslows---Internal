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
class Dataservice_Form_Element_EmployeeSelect extends Zend_Form_Element_Select {
    public function init() {	
        $this->addMultiOption("", 'Please select...');
        foreach (Services\Employee::factory()->getEmployees() as $Employee) {
            $this->addMultiOption($Employee->getId(), $Employee->getFullName());
        }
    }
}

?>
