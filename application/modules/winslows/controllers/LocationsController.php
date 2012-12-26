<?php
class Winslows_LocationsController extends Dataservice_Controller_Action
{
    public function searchAction()
    {
	$distance = 200;
	$address  = 75169;
	$Form	  =  new Forms\Company\Location\Search(array("method" => "post"));
	
	if($this->isPostAndValid($Form))
	{
	    $address	= $this->getRequest()->getParam("address");
	    $distance	= $this->getRequest()->getParam("range");
	}
	
	$this->view->Locations = $this->getWebsite()
				    ->getCompany()
				    ->getLocationsWithinDistanceOfAddress($distance, $address);
	
	$this->view->Form	= $Form;
	$this->view->search_key	= Dataservice\Map::getLatLongFromAddress($address);
    }
}


