<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SupplierSelect
 *
 * @author jgreen
 */
class Dataservice_Form_Element_SupplierSelect extends Zend_Form_Element_Select {
    public function init() {	
        $this->addMultiOption("", 'Please select...');
        foreach (Services\Supplier::factory()->getAllSuppliers() as $Supplier) {
            $this->addMultiOption($Supplier->getId(), $Supplier->getName());
        }
    }
}

?>
