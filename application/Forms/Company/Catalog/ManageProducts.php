<?php
namespace Forms\Company\Catalog;

class ManageProducts extends \Dataservice_Form
{
    private $_Catalog;
    
    public function __construct(\Entities\Company\Catalog $Catalog, $options = null)
    {
	$this->_Catalog = $Catalog;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new ManageProducts\Subform($this->_Catalog, $options);
	
	$this->addSubForm($form, "company_catalog_manage_products");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}