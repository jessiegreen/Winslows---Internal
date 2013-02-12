<?php
class Dataservice_Form_Element_Company_Website_Role_Resources_MultiCheckbox extends Zend_Form_Element_MultiCheckbox
{
    private $_Role;
    
    public function __construct(Entities\Company\Website\Role $Role, $spec, $options = null)
    {
	$this->_Role = $Role;
	
	parent::__construct($spec, $options);
    }
    
    public function init()
    {	
        foreach ($this->_Role->getWebsite()->getResources() as $Resource)
	{
            $this->addMultiOption($Resource->getId(), $Resource->getName());
        }
    }
}