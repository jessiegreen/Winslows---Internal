<?php
/**
 * Description of IndexController
 *
 * @author Jessie
 */

class Texwin_CarportsController extends Dataservice_Controller_Action
{

    public function init()
    {
        $this->view->headLink()->appendStylesheet(BASE_URL.'/css/carports.css');
	$this->view->headScript()->prependFile(BASE_URL.'/javascript/jquery.accordian.js');
    }

    public function indexAction()
    {
	
    }

    public function builderAction()
    {
	
    }

    private function getDataModel($name){
	$name = ucfirst(strtolower($name));
	require_once APPLICATION_PATH.'/models/'.$name.'.php';
	$model = new $name();
	return $model;

    }
}

