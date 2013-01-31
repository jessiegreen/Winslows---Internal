<?php
class Dataservice_Form_Element_Company_Website_Roles_MultiCheckbox extends Zend_Form_Element_MultiCheckbox
{
    private $_Website;
    
    public function __construct(Entities\Company\Website\WebsiteAbstract $Website, $spec, $options = null)
    {
	$this->_Website = $Website;
	
	parent::__construct($spec, $options);
    }
    
    public function init()
    {	
        foreach ($this->_Website->getRoles() as $Role)
	{
            $this->addMultiOption($Role->getId(), $Role->getName());
        }
    }
}