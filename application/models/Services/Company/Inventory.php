<?php
namespace Services\Company;

class Inventory extends \Dataservice_Service_ServiceAbstract
{
    public function getCurrentCompanyInventory()
    {
	return \Services\Company::factory()->getInventory();
    }
}