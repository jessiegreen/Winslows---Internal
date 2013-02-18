<?php
class Winslows_CategoryController extends Dataservice_Controller_Action
{
    public function viewAction()
    {
	echo $this->_getParam("category_index");
    }
}


