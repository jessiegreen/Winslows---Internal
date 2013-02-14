<?php
namespace Forms\Company\Catalog\ManageWebsites;

class Subform extends \Zend_Form_SubForm
{
    private $_Catalog;
    
    public function __construct(\Entities\Company\Catalog $Catalog, $options = null)
    {
	$this->_Catalog = $Catalog;
	
	parent::__construct($options);
    }
    
    public function init()
    {	
	$values = array();
	
	if($this->_Catalog)
	{
	    foreach($this->_Catalog->getWebsites() as $Website)
	    {
		$values[] = $Website->getId();
	    }
	}
	
	$this->addElement(new \Dataservice_Form_Element_Company_Website_MultiCheckbox("websites", array(
            'required'	    => false,
            'label'	    => 'Websites:',
	    'value'	    => $values
        )));
	
	$this->setElementsBelongTo("company_catalog_manage_websites");
    }
}