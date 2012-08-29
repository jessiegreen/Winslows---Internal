<?php
namespace Services\Company\Lead\Quote;

class Item extends \Dataservice_Service_ServiceAbstract
{
    /**
     * @param \Entities\Company\Lead\Quote\Item $Item
     * @return array
     */
    public function getSaleTypeOptions(\Entities\Company\Lead\Quote\Item $Item)
    {
	$sales_options = array("cash" => "Cash Sale");

	if(!$Item->getInstance())
	{
	    foreach(\Services\RtoProvider::factory()->getAllRtoProviders() as $RtoProvider) 
	    {
		$sales_options[$RtoProvider->getNameIndex()] = $RtoProvider->getDba()." - Rent To Own";
	    }
	}
	else
	{
	    foreach($Item->getInstance()->getProduct()->getRtoProviders() as $RtoProvider) 
	    {
		$sales_options[$RtoProvider->getNameIndex()] = $RtoProvider->getDba()." - Rent To Own";
	    }
	}
	    
	return $sales_options;
    }
}