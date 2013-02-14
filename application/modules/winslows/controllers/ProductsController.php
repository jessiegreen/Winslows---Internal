<?php
class Winslows_ProductsController extends Dataservice_Controller_Action
{
    public function indexAction()
    {
	$this->view->Catalog = $this->_Website->getCatalogByIndex("winslows");
    }
}


