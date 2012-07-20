<?php
/**
 * Description of LocationSelect
 *
 * @author jgreen
 */
class Dataservice_Form_Element_LocationSelect extends Zend_Form_Element_Select
{
    public function init()
    {	
        $this->addMultiOption("", 'Please select...');
        foreach (Services\Location::factory()->getLocations() as $Location) {
            $this->addMultiOption($Location->getId(), $Location->getName());
        }
    }
}

?>
