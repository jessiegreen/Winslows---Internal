<?php
class Dataservice_Form_Element_Company_Catalog_Category_Select extends Zend_Form_Element_Select
{
    protected $_Category;
    
    /**
     * @param Entities\Company\Catalog\Category $Category
     * @param string | array | Zend_Config $spec
     * @param array | Zend_Config $options
     */
    public function __construct(Entities\Company\Catalog\Category $Category, $spec, $options = null) 
    {
	$this->_Category = $Category;
	
	parent::__construct($spec, $options);
    }
    
    public function init()
    {	
        $this->addMultiOption("", 'Please select...');
        
	foreach($this->_Category->getCatalog()->getCategories() as $Category)
	{
	    $this->addMultiOption($Category->getId(), $Category->getNameWithParentsString());
        }
    }
}