<?php
use \Dataservice\Html\CRUD;

class Dataservice_View_Helper_CRUD_Manage extends Zend_View_Helper_Abstract
{
    public function CRUD_Manage($header)
    {
	echo($this->view->flashMessages()); 

	CRUD\Header::factory($header)->render();
	CRUD\Body::factory()->start();
	echo $this->view->form;
	CRUD\Body::factory()->end();
    }
}
