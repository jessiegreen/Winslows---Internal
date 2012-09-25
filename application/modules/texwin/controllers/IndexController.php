<?php
/**
 * Description of IndexController
 *
 * @author Jessie
 */

class Texwin_IndexController extends Dataservice_Controller_Action
{

    public function init()
    {
        $this->view->headLink()->appendStylesheet(BASE_URL.'/css/index.css');
    }

    public function indexAction()
    {
	$this->view->headTitle()->append("Home - Manufacturer of Quality Carports, Buildings, and Structures");
	$this->view->headLink()->appendStylesheet(BASE_URL.'/css/slides.css');
	$this->view->headScript()->appendFile(BASE_URL.'/javascript/slides.min.jquery.js');
	
	require_once APPLICATION_PATH."/models/Categories.php";
	
	$Categories = new Categories();
	
	$this->view->categories	= $Categories->getAllCategoriesInfo();
    }
    
    public function index_1Action()
    {
	$this->view->headTitle()->append("Home - Manufacturer of Quality Carports and Structures");
	
	require_once APPLICATION_PATH."/models/Products.php";
	
	$Products = new Products;
	
	$this->view->info	= $Products->getAllProductsInfo();
    }

    public function whytexwinAction(){
	$this->view->headTitle()->append("Why Buy Texwin Carports?");
    }

    public function galleryAction(){
	$this->view->headTitle()->append("Gallery - Pictures of Our Carports and Structures");
    }
    
    public function aboutusAction(){
	$this->view->headTitle()->append("About Us");
    }
    
    public function qualitycontrolAction(){
	$this->view->headTitle()->append("Commited To Quality Carports");
    }
    
    public function financingAction(){
	$this->view->headTitle()->append("How To Finance Your Carports");
    }

    private function getDataModel($name){
	$name = ucfirst(strtolower($name));
	require_once APPLICATION_PATH.'/models/'.$name.'.php';
	$model = new $name();
	return $model;

    }
    
}

