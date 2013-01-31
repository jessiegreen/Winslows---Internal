<?php
namespace Forms\Company\Lead\Quote\SalesTypes;
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
    /* @var $Quote \Entities\Company\Lead\Quote */
    private $Quote;
    
    public function __construct(\Entities\Company\Lead\Quote $Quote, $options = null)
    {
	$this->Quote = $Quote;
	
	parent::__construct($options);
    }
    
    public function init() 
    {
	/* @var $Item \Entities\Company\Lead\Quote\Item */
	foreach ($this->Quote->getItems() as $Item)
	{
	    /* @var $Instance \Entities\Company\Supplier\Product\Instance\InstanceAbstract */
	    $Instance	= $Item->getInstance();
	    /* $Product Entities\Company\Supplier\Product\ProductAbstract */
	    $Product	= $Instance->getProduct();
	    
	    $sales_options = array("cash" => "Cash Sale");
	    
	    foreach($Product->getRtoProviders() as $RtoProvider) 
	    {
		$sales_options[$RtoProvider->getNameIndex()] = $RtoProvider->getDba()." - Rent To Own";
	    }
	    
	    /* @var $Instance \Entities\Company\Supplier\Product\Configurable\Instance */
	    $this->addElement("select", $Item->getId()."_sales_type", 
				array(
				    "label"	    => $Instance->getPrice()->getDisplayPrice()."-".$Product->getName(),
				    "multioptions"  => $sales_options,
				    "required"	    => true
				));
	    
	}
	
	parent::init();
    }
}