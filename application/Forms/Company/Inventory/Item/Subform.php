<?php
namespace Forms\Company\Inventory\Item;
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
    
    public function __construct(\Entities\Company\Inventory\Item $Item, $options = null)
    {
	$this->_Item = $Item;
	
	parent::__construct($options);
    }
    
    public function init() 
    {
	$this->addElement(new \Dataservice_Form_Element_Company_AllLocationSelect(
		$this->_Item->getInventory()->getCompany(),
		"location_id", array(
		    'label'	    => 'Location:',
		    'belongsTo'	    => 'company_inventory_item',
		    'value'	    => $this->_Item && $this->_Item->getLocation() ? $this->_Item->getLocation() : ""
		)));
	
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