<?php
class Winslows_IndexController extends Dataservice_Controller_Action
{        
    public function indexAction()
    {
	$this->view->headScript()->appendFile("/javascript/winslows/index/index/slider.js");
	$this->view->headScript()->appendFile("/javascript/winslows/index/index/banner.js");

        $this->view->Categories = $this->_Website->getCatalogByIndex("winslows")->getTopCategories();
    }
}

