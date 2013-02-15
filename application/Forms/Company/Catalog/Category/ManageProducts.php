<?php
namespace Forms\Company\Catalog\Category;

class ManageProducts extends \Dataservice_Form
{
    private $_Category;
    
    public function __construct(\Entities\Company\Catalog\Category $Category, $options = null)
    {
	$this->_Category = $Category;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new ManageProducts\Subform($this->_Category, $options);
	
	$this->addSubForm($form, "company_catalog_category_manage_products");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}