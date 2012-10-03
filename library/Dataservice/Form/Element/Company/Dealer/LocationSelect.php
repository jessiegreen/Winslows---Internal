<?php
/**
 * Description of LocationSelect
 *
 * @author jgreen
 */
class Dataservice_Form_Element_Company_Dealer_LocationSelect extends Zend_Form_Element_Select
{
    public function init()
    {	
        $this->addMultiOption("", 'Please select...');
	
        foreach (Services\Company\Dealer\Location::factory()->getAllLocations() as $Location)
	{
            $this->addMultiOption($Location->getId(), $Location->getName());
        }
    }
}