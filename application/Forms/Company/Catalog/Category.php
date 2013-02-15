<?php
namespace Forms\Company\Catalog;

class Category extends \Dataservice_Form
{    
    private $_Category;
    
    public function __construct(\Entities\Company\Catalog\Category $Category, $options = null)
    {
	$this->_Category = $Category;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Category\Subform($this->_Category, $options);
	
	$this->addSubForm($form, "company_catalog_category");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}
