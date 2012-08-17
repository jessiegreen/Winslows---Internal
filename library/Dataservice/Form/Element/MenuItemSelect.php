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
class Dataservice_Form_Element_MenuItemSelect extends Zend_Form_Element_Select
{
    public function init()
    {	
        $this->addMultiOption("", 'Please select...');
        
	foreach(Services\Company\Website\Menu::factory()->getAllMenuItems() as $MenuItem)
	{
            $this->addMultiOption($MenuItem->getId(), $MenuItem->getMenu()->getName()." - ".$MenuItem->getLabel());
        }
    }
}