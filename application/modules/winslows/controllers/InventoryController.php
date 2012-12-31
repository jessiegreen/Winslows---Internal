<?php
class Winslows_InventoryController extends Dataservice_Controller_Action
{
    public function indexAction()
    {
	$this->view->Items = $this->_Website->getCompany()->getInventory()->getItemsByProduct();
    }
}


