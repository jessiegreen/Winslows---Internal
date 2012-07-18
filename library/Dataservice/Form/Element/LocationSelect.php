<?php
/**
 * Description of LocationSelect
 *
 * @author jgreen
 */
class Dataservice_Form_Element_LocationSelect extends Zend_Form_Element_Select {
    public function init() {
        $LocationService = new Services\Location\Location();
	
        $this->addMultiOption("", 'Please select...');
        foreach ($LocationService->getLocations() as $Location) {
            $this->addMultiOption($Location->getId(), $Location->getName());
        }
    }
}

?>
