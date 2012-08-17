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
class Dataservice_Form_Element_MenuSelect extends Zend_Form_Element_Select
{
    public function init()
    {	
        $this->addMultiOption("", 'Please select...');
        
	foreach (Services\Company\Website\Menu::factory()->getAllMenus() as $Menu)
	{
            $this->addMultiOption($Menu->getId(), $Menu->getName());
        }
    }
}