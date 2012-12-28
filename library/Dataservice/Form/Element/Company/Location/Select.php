<?php
/**
 * Description of LocationSelect
 *
 * @author jgreen
 */
class Dataservice_Form_Element_Company_Location_Select extends Zend_Form_Element_Select
{
    private $_Company;
    
    public function __construct(Entities\Company $Company, $spec, $options = null)
    {
	$this->_Company = $Company;
	
	parent::__construct($spec, $options);
    }
    public function init()
    {	
        $this->addMultiOption("", 'Please select...');
	
        foreach ($this->_Company->getLocations() as $Location)
	{
            $this->addMultiOption($Location->getId(), $Location->getName());
        }
    }
}