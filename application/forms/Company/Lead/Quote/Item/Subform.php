<?php
namespace Forms\Company\Lead\Quote\Item;
/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Subform extends \Zend_Form_SubForm
{    
    private $_Item;
    
    public function __construct(\Entities\Company\Lead\Quote\Item $Item, $options = null)
    {
	$this->_Item = $Item;
	parent::__construct($options);
    }
    
    public function init() 
    {
	$this->addElement(
		"text", 
		"name", 
		array(
		    "label"	=> "Name",
		    "description" => "Customer friendly name for the Item. (Optional)",
		    "required"	=> false,
		    "value"	=> $this->_Item ? $this->_Item->getName() : "",
		    "belongsTo" => "quote",
		)
	    );
	
	$this->addElement(
		"hidden", 
		"instance_id", 
		array(
		    "required"	=> false,
		    "value"	=> $this->_Item && $this->_Item->getInstance() ? $this->_Item->getInstance()->getId() : "",
		    "belongsTo" => "quote",
		)
	    );
	
	if(!$this->_Item || !$this->_Item->getInstance())
	{
	    $this->addElement(new \Dataservice_Form_Element_ProductSelect("product_id", array(
		'label'	    => 'Product:',
		'belongsTo' => 'quote',
		'value'	    => $this->_Item && $this->_Item->getInstance() && $this->_Item->getInstance()->getProduct()
				    ? $this->_Item->getInstance()->getProduct()->getId() 
				    : ""
	    )));
	    
	}
	
	$sales_options = \Services\Company\Lead\Quote\Item::factory()->getSaleTypeOptions($this->_Item);
	
	$this->addElement("select", "sale_type", 
			    array(
				"label"		=> "Sale Type",
				"multioptions"  => $sales_options,
				"required"	=> true,
				'validators'	=> array(new \Dataservice_Validate_Company_Lead_Quote_Item_SaleType()),
				"value"		=> $this->_Item  ? $this->_Item->getSaleType() : ""
			    ));
	
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
		    "multioptions"  => $options,
		    "belongsTo"	    => "quote",
		)
	    );
	
	parent::init();
    }
}