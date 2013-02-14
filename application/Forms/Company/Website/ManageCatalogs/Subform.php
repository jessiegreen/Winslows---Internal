<?php
namespace Forms\Company\Website\ManageCatalogs;

class Subform extends \Zend_Form_SubForm
{
    private $_Website;
    
    public function __construct(\Entities\Company\Website $Website, $options = null)
    {
	$this->_Website = $Website;
	
	parent::__construct($options);
    }
    
    public function init()
    {	
	$values = array();
	
	if($this->_Website)
	{
	    foreach($this->_Website->getCatalogs() as $Catalog)
	    {
		$values[] = $Catalog->getId();
	    }
	}
	
	$this->addElement(new \Dataservice_Form_Element_Company_Catalog_MultiCheckbox("catalogs", array(
            'required'	    => false,
            'label'	    => 'Catalogs:',
	    'value'	    => $values
        )));
	
	$this->setElementsBelongTo("company_website_manage_catalogs");
    }
}