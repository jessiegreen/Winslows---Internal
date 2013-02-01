<?php
use \Dataservice\Html\CRUD;

class Dataservice_View_Helper_CRUD_Edit extends Zend_View_Helper_Abstract
{
    public function CRUD_Edit($header, $Entity)
    {
	echo($this->view->flashMessages()); 

	CRUD\Header::factory($header." - ".($Entity->getId() ? "Edit" : "Add"))->render();
	CRUD\Body::factory()->start();
	echo $this->view->form;
	CRUD\Body::factory()->end();
    }
}
