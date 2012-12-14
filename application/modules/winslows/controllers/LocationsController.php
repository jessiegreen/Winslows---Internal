<?php
class Winslows_LocationsController extends Dataservice_Controller_Action
{
    public function searchAction()
    {
	$this->view->Locations = Services\Winslows\Location::factory()->getAllCompanyLocations();	
    }
}


