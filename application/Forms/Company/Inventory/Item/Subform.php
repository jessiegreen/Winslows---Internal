<?php
namespace Forms\Company\Inventory\Item;

class Subform extends \Zend_Form_SubForm
{    
    private $_Item;
    
    public function __construct(\Entities\Company\Inventory\Item $Item, $options = null)
    {
	$this->_Item = $Item;
	
	parent::__construct($options);
    }
    
    public function init() 
    {
	if(!$this->_Item->getInstance())
	{
	    $this->addElement(new \Dataservice_Form_Element_ProductSelect(
		"product_id", array(
		    'label'	    => 'Product:',
		    'value'	    => ""
		)));
	}
	
	$this->addElement(new \Dataservice_Form_Element_Company_AllLocationSelect(
		$this->_Item->getInventory()->getCompany(),
		"location_id", 
		array(
		    'label'	    => 'Location:',
		    'value'	    => $this->_Item && $this->_Item->getLocation() ? $this->_Item->getLocation()->getId() : ""
		)
	    )
	);
	
	foreach(range(1, 50) as $i)
	{
	    $options[$i] = $i;
	}

	$this->addElement(
		"select", 
		"quantity", 
		array(
		    "label"	    => "Quantity:",
		    "required"	    => true,
		    "value"	    => $this->_Item ? $this->_Item->getQuantity() : 0,
		    "multioptions"  => $options
		)
	    );
	
	parent::init();
	
	$this->setElementsBelongTo("company_inventory_item");
    }
}