<?php
/**
 * Description of IndexController
 *
 * @author Jessie
 */

class Texwin_ProductsController extends Dataservice_Controller_Action
{

    public function init()
    {
	#--Set title
	$this->view->headTitle()->append("Products");
        $this->view->headLink()->appendStylesheet(BASE_URL.'/css/carports.css');
	$this->view->headLink()->appendStylesheet(BASE_URL.'/css/products.css');
	$this->view->headScript()->prependFile(BASE_URL.'/javascript/jquery.accordian.js');
    }

    public function indexAction()
    {
	require_once APPLICATION_PATH."/models/Categories.php";
	
	$Categories		= new Categories();
	$this->view->products	= $Categories->getAllCategoriesInfo();
    }

    public function builderAction()
    {
	$this->view->headTitle()->append("Carport Builder");
    }
    
    public function viewAction(){
	require_once APPLICATION_PATH.'/models/Categories.php';
	$Categories   = new Categories();
	$params	    = $this->getRequest()->getParams();
	
	if(isset ($params['name'])){
	    $category = $Categories->getCategoryInfoByName(urldecode($params['name']));
	    if(count($category)>0){
		$this->view->product = $category;
	    }
	    else{
		$this->_helper->redirector('index', 'products');
	    }
	}
	else{
	    $this->_helper->redirector('index', 'products');
	}
    }
}

