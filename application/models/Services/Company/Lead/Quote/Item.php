<?php
namespace Services\Company\Lead\Quote;

class Item extends \Dataservice_Service_ServiceAbstract
{
    public static function getItemsCompanyLocationAddresses(\Entities\Company\Lead\Quote\Item $Item)
    {
	$Addresses = new \Doctrine\Common\Collections\ArrayCollection;
	
	foreach($Item->getQuote()->getLead()->getCompany()->getLocations() as $Location)
	{
	    if($Location->getAddress())
		$Addresses->add($Location->getAddress());
	}
	
	return $Addresses;
    }
}